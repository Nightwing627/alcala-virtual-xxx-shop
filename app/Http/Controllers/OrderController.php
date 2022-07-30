<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Customer;
use App\Factura;
use Carbon\Carbon;
use Images;
use Documents;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('customer', 'customer.user')->get();
        
        foreach($orders as $order){
            $order->total = '$'.$order->total;
            $order->subtotal = '$'.$order->subtotal;
        }

        $totalDay  = Order::where('status', 'pagado')->whereDate('created_at', Carbon::today())->sum('total'); 
        $totalc    = Order::where('status', 'pendiente')->whereDate('created_at', Carbon::today())->sum('total');
        $totalMoth = Order::where('status', 'pagado')->whereDate('created_at', '>', Carbon::now()->subDays(30))->sum('total'); 
        $total     = Order::where('status', 'pendiente')->whereDate('created_at', '>', Carbon::now()->subDays(30))->sum('total');

        return ['orders' => $orders, 'totals' => [ 'totalToDay' => $totalDay, 'totalMonth'=> $totalMoth, 'total'=> $total, 'totalc'=> $totalc]];
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = [];
        $detalles = [];

        $order = Order::where('id', $id)->with('town', 'state')->first();
        
        if($order){
            $customer = Customer::where('id', $order->customer_id)->with('user')->first();
            $details = OrderDetail::where('order_id', $order->id)->with('product')->get();
            $factura = Factura::where('order_id', $order->id)->with('state','town')->first();
            $order->pdf = Documents::getUrl($order->document_id);
            
            foreach ($details as $key => $value) {
                $value->product->image = Images::getImg($value->product->image_id);
            }
        }

        return  ['order' => $order, 'customer' => $customer, 'details' => $details, 'factura' => $factura];
    }

    //front
    public function historialCompras(Request $request)
    {
        $data = [];
        $historial = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->where('orders.customer_id',$request->customer_id)
        ->orderBy('order_details.id', 'DESC')
        ->select('orders.id', 'orders.status', 'orders.created_at', 'products.name as productName', 'products.id as product_id', 'products.image_id as product_image_id', 'order_details.quantity as cantidad', 'order_details.price as precio')
        ->get();

        foreach ($historial as $key => $value) {
            if($value->product_image_id){
                $value->fecha = $value->created_at->format('d-m-Y');
                $value->productImage=Images::getUrl($value->product_image_id);
            }
            
            array_push($data, $value);
        }

        return $data;
    }

    public function setStatus(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        if($order)
        {
            if($order->status != $request->status)
            {
                $order->status = $request->status;
                $order->save();
            }
            return response()->json(['msg'=>'Pedido actualizado correctamente'],200);
        }
        else
            return response()->json(['msg'=>'Ocurrio un error al actualizar el pedido'],500);

    }
}
