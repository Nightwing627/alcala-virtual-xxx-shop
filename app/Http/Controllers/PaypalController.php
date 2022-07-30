<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use App\Mail\Notice;
use App\Mail\NewCustomer;

use App\Product;
use App\Order;
use App\OrderDetail;
use App\User;
use App\Customer;
use App\Extra;
use App\Factura;
use App\Coupon;
use App\Document;

use Carbon\Carbon;
use Images;
use Documents;
use PDF;

//paypal
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    private $apiContext;

    private function inicializarPaypal()
    {

      $produccion = true; //Bandera principal (true para modo produccion y false para modo sandbox)

      //Inicializamos las variables
      $PAYPAL_CLIENT_ID = $produccion ? config('services.paypal.production_client_id') : config('services.paypal.sandbox_client_id');
      $PAYPAL_SECRET = $produccion ? config('services.paypal.production_secret') : config('services.paypal.sandbox_secret');
      $PAYPAL_MODE = $produccion ? 'live' : 'sandbox';

      //Inicializamos la conexion con las credenciales seleccionadas
      $this->apiContext = new ApiContext(new OAuthTokenCredential($PAYPAL_CLIENT_ID, $PAYPAL_SECRET));
      $this->apiContext->setConfig(['mode' => $PAYPAL_MODE, //'sandbox o live'
                                    'log.LogEnabled' => true,
                                    'log.FileName' => storage_path() . '/logs/paypal.log',
                                    'log.LogLevel' => 'INFO', // PLEASE USE INFO LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                                    'cache.enabled' => true,
                                    'cache.FileName' => '../auth.cache']);
    }

    public function payment(Request $request)
    {
        //Paso 1 Convertir el json
        $body = json_decode($request->body);

        //verificamos si el correo del  cliente ya esta en uso
        if(!$body->userLogin && $user = User::where('email', $body->user->email)->first()){
            return response()->json(["error"=> "El correo electronico ya esta en uso"]);
        }

      $this->inicializarPaypal();

      //Vamos a capturar la info del comprador.
      $payer = new Payer();
      $payer->setPaymentMethod('paypal');
      $articulos = [];

      foreach ($body->products as $key => $articulo)
      {
          $item = new Item();
          $item->setName($articulo->name)
            ->setCurrency('MXN')
            ->setDescription('SKU:'.$articulo->sku)
            ->setQuantity($articulo->cantidad)
            ->setPrice($articulo->price); 
        
        array_push($articulos, $item);
      }

      //Si tuviesemos descuentos o promociones, entonces es posible agregar articulos con cantidades negativas.
      if($body->cupon->descuentoAplicado == true)
      {
          $item = new Item();
          $item->setName("Descuento por cupon(".$body->cupon->cupon.")")
              ->setCurrency('MXN')
              ->setPrice("-".$body->cupon->cantidadDescontada)
              ->setQuantity(1);
          
          array_push($articulos, $item);
      }

      $item_list = new ItemList();
      $item_list->setItems($articulos);

      $amountDetails = new Details();
      $amountDetails->setSubtotal($body->pedido->subtotal)->setShipping($body->pedido->envio);

      $amount = new Amount();
      $amount->setCurrency('MXN')->setTotal($body->pedido->total)->setDetails($amountDetails);
      
      $transaction = new Transaction();
      $transaction->setAmount($amount)->setItemList($item_list)->setDescription('vsexshopgdlalcala.com.mx');

      $redirect_urls = new RedirectUrls();
      $redirect_urls->setReturnUrl("https://vsexshopgdlalcala.com.mx/?#/carrito")->setCancelUrl("https://vsexshopgdlalcala.com.mx/?#/carrito");
      
      $payment = new Payment();
      $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

      try{
          $payment->create($this->apiContext);
      }catch(Exception $ex){
          echo $ex->getCode(); 
          echo $ex->getData();
          die($ex);
      }
      
      return response()->json(['estado'=>'ok','payment_id'=>$payment->id]);
    }

    public function onAuthorize(Request $request)
    {
      $this->inicializarPaypal();

      //Paso 1 Convertir el json en arreglo
      $body = json_decode($request->body);

      $paymentId = $request->paymentID;
      $payment = Payment::get($paymentId, $this->apiContext);

      $execution = new PaymentExecution();
      $execution->setPayerId($request->payerID);

      //Aqui merooo se executa la transaccion, en caso de que falle, se manda al catch para ver el error.
      $paypal_results = $payment->execute($execution, $this->apiContext);
      //transaction ID
      $transactions = $payment->getTransactions();
      $related_resources = $transactions[0]->getRelatedResources();
      $sale = $related_resources[0]->getSale();
      $transactionId = $sale->getId();

      //A partir de aqui el pago ya se realizo exactamente
      if($paypal_results->getState() === 'approved'){
          $order = $this->orderStore($body, $paypal_results, $transactionId);
          return response()->json(['estado' => 'ok','pedido' => $order]);

      }else{
        return response()->json(['estado' => 'error']);
      }

      return response()->json(['estado' => 'error']);
    }

    private function orderStore($request, $paypal_results, $transactionId)
    {
        $usuario = $request->user;
        if($request->userLogin){
            $user = User::where('id', $request->user->id)->first();
        } else{
            $user = $this->createCustomer($request->user);
        }

        $productos = $request->products;
        $total = $request->pedido->total;
        $subtotal = $request->pedido->subtotal;

        //crear pedido
        $order = new Order();
        //direccion
        $order->street = $usuario->street;
        $order->num_ext = $usuario->num_ext;

        if($usuario->num_int){
            $order->num_int = $usuario->num_int ? $usuario->num_int : null;
        }
        
        $order->neighborhood = $usuario->neighborhood;
        $order->postalCode = $usuario->postalCode;
        $order->state_id = $usuario->state_id;
        $order->town_id = $usuario->town_id;
        //totales y metodo de pago
        $order->subtotal = $subtotal;
        $order->total = $total;
        $order->status = "pagado";
        $order->PaymentMethod = 'PayPal';
        $order->shippingCost = $request->pedido->envio;
        $order->customer_id = $user->customer->id;
        //Metodos de pago
        $order->paypal_payerId = $paypal_results->payer->payer_info->payer_id;
        $order->transactionId = $transactionId;
        $order->save();

        //detalle de pedido
        foreach($productos as $producto){
            $product = Product::find($producto->id);
            if($product){
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->quantity = $producto->cantidad;
                $orderDetail->price = $producto->price;
                $orderDetail->save();
            }
        }

        //Si hay datos de fatura entonces se registra
        $factura = $request->factura;
        if($factura->factura == true)
        {
            $f = new Factura();
            $f->order_id = $order->id;
            $f->nombre  = $factura->nombre;
            $f->rfc = $factura->rfc;
            $f->cuenta = $factura->cuenta;
            $f->tipo = $factura->tipo;
            $f->correo = $factura->correo;
            $f->direccion = $factura->direccion;
            $f->no_ext = $factura->no_ext;
            $f->no_int = $factura->no_int;
            $f->calles = $factura->calles;
            $f->telefono = $factura->telefono;
            $f->cp = $factura->cp;
            $f->state_id = $factura->estado;
            $f->town_id = $factura->ciudad;
            $f->colonia = $factura->colonia;
            $f->save();
        }
        
        try{
            $pdf = $this->createPDF($order, $user);
            
            Mail::to('isaiasalcala@hotmail.com')->send(new Notice( $order, $user, $pdf));
            Mail::to('ventas@vsexshopgdlalcala.com.mx')->send(new Notice( $order, $user, $pdf));
            Mail::to($user->email)->send(new OrderMail( $order, $user, $pdf));
        }catch (\Exception $e) {
            return $order;
        }

        return $order;
    }

    private function createCustomer($formUser)
    {
        $usuario = ['email' => $formUser->email, 'name' => $formUser->name, 'password' => str_random(8)];

        $user = new User();
        $user->email = $formUser->email;
        $user->name = $formUser->name;
        $user->lastname = $formUser->lastname;
        $user->password = bcrypt($usuario['password']);
        $user->phone = $formUser->phone;
        $user->access = 0;
        $user->save();
        $user->syncRoles(['Cliente']);

        $customer = new Customer();
        $customer->street = $formUser->street;
        $customer->num_ext = $formUser->num_ext;
        if($formUser->num_int){
            $customer->num_int = $formUser->num_int ? $formUser->num_int : null;
        }
        $customer->neighborhood = $formUser->neighborhood;
        $customer->postalCode = $formUser->postalCode;
        $customer->state_id = $formUser->state_id;
        $customer->town_id = $formUser->town_id;
        $customer->user_id = $user->id;
        $customer->save();

        Mail::to($user->email)->queue(new NewCustomer($usuario));

        return $user;        
    }

    private function createPDF($order, $user)
    {
      ini_set('memory_limit', '-1');

      $pdf = PDF::loadView('plantillas.pedido',['order' => $order, 'user' => $user]);
      $content = $pdf->download()->getOriginalContent();

      // Crear el archivo y almacenarlo en el storage
      Storage::disk('public')->put('docs/pedido-'.$order->id.'.pdf',$content);
      
      //Crear el registro del documento y guardar el id en el pedido
      $doc = new Document(array(
        "path"=>'docs/pedido-'.$order->id.'.pdf',
        "disk"=>'public',
        "key"=>uniqid()
      ));

      $doc->save();

      $doc_url = Documents::getUrl($doc->id); 
      $order->document_id = $doc->id;
      $order->save();

      return $content;
    }
}