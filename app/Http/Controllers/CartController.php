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

class CartController extends Controller
{
    public function obtenerProductos(Request $request)
    {
        $cart = [];
        $deposito = Extra::where('key', 'DEPOSITO')->first();

        foreach($request->productos as $producto){
            $product = Product::find($producto['id']);

            if($product){
                $cart[] = [
                    'id'       => $product->id,
                    'sku'      => $product->sku,
                    'name'     => $product->name,
                    'price'    => $product->price,
                    'imageUrl' => Images::getUrl($product->image_id),
                    'cantidad' => $producto['cantidad'],
                    'stock'    => $product->stock
                ];
            }
        }

        return response()->json(['cart' => $cart, 'deposito' => $deposito]);
    }

    public function OrderStore(Request $request)
    {
        try{
            $usuario = $request->user;
            if($request->userLogin){
                $user = User::where('id', $request->user['id'])->first();
            }else{
                if($user = User::where('email',$request->user['email'])->first()){
                    return response()->json(["error"=>"El correo electronico ya esta en uso"]);
                }else{
                    $user = $this->createCustomer($request->user);
                }
            }

            $productos = $request->products;
            $total = $request->pedido['total'];
            $subtotal = $request->pedido['subtotal'];

            //crear pedido
            $order = new Order();
            $order->street = $usuario['street'];
            $order->num_ext = $usuario['num_ext'];
            $order->num_int = isset($usuario['num_int']) ? $usuario['num_int'] : null;
            $order->neighborhood = $usuario['neighborhood'];
            $order->postalCode = $usuario['postalCode'];
            $order->state_id = $usuario['state_id'];
            $order->town_id = $usuario['town_id'];
            $order->subtotal = $subtotal;
            $order->total = $total;
            $order->status = "pendiente";
            $order->PaymentMethod = 'Deposito';
            $order->shippingCost = $request->pedido['envio'];
            $order->customer_id = $user->customer->id;

            if($request->cupon != '')
            {
                $cupon = Coupon::where('codigo',$request->cupon)->first();
                if($cupon){
                    $order->cupon = $cupon->codigo;
                    $order->descuento = $cupon->porcentaje;
                    $order->cantidadDescontada = ($subtotal * ($cupon->porcentaje / 100));
                    $order->save();
                }
            }

            $order->save();

            //detalle de pedido
            foreach($productos as $producto){
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->product_id = $producto['id'];
                $detail->quantity = $producto['cantidad'];
                $detail->price = $producto['price'];
                $detail->save();
            }

            //Si hay datos de fatura entonces se registra
            $factura = $request->factura;
            if($factura['factura'] == true)
            {
                $f = new Factura();
                $f->order_id = $order->id;
                $f->nombre  = $factura['nombre'];
                $f->rfc = $factura['rfc'];
                $f->cuenta = $factura['cuenta'];
                $f->tipo = $factura['tipo'];
                $f->correo = $factura['correo'];
                $f->direccion = $factura['direccion'];
                $f->no_ext = $factura['no_ext'];
                $f->no_int = $factura['no_int'];
                $f->calles = $factura['calles'];
                $f->telefono = $factura['telefono'];
                $f->cp = $factura['cp'];
                $f->state_id = $factura['estado'];
                $f->town_id = $factura['ciudad'];
                $f->colonia = $factura['colonia'];
                $f->save();
            }

            $pdf = $this->createPDF($order, $user);
            
            Mail::to('isaiasalcala@hotmail.com')->send(new Notice( $order, $user, $pdf));
            Mail::to('ventas@vsexshopgdlalcala.com.mx')->send(new Notice( $order, $user, $pdf));
            Mail::to($user->email)->send(new OrderMail( $order, $user, $pdf));

            return response()->json(['type' => "success", 'order_id' => $order->id]);
            
        }catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function createCustomer($formUser)
    {
        $usuario = ['email' => $formUser['email'], 'name' => $formUser['name'], 'password' => str_random(8)];

        $user = new User();
        $user->email = $formUser['email'];
        $user->name = $formUser['name'];
        $user->lastname = $formUser['lastname'];
        $user->password = bcrypt($usuario['password']);
        $user->phone = $formUser['phone'];
        $user->access = 0;
        $user->save();
        $user->syncRoles(['Cliente']);

        $customer = new Customer();
        $customer->street = $formUser['street'];
        $customer->num_ext = $formUser['num_ext'];
        if(isset($formUser['num_int'])){
            $customer->num_int = $formUser['num_int'] ? $formUser['num_int'] : null;
        }
        $customer->neighborhood = $formUser['neighborhood'];
        $customer->postalCode = $formUser['postalCode'];
        $customer->state_id = $formUser['state_id'];
        $customer->town_id = $formUser['town_id'];
        $customer->user_id = $user->id;
        $customer->save();

        Mail::to($user->email)->queue(new NewCustomer($usuario));

        return $user;        
    }

    public function createPDF($order, $user)
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
