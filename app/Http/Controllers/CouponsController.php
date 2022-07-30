<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Coupon;
use App\CouponHistory;
use App\Modelo;

class CouponsController extends Controller
{
    public function index()
    {
        $cupones = Coupon::all();
        return response()->json($cupones);
    }
    public function store(Request $request)
    {
        $cupon = new Coupon();
        $cupon->nombre = $request->nombre;
        $cupon->stock = $request->stock;
        $cupon->codigo = $request->codigo;
        $cupon->porcentaje = $request->porcentaje;
        $cupon->fechaInicio = $request->fechaInicio ? $request->fechaInicio : null;
        $cupon->fechaFin = $request->fechaFin ? $request->fechaFin : null;
        $cupon->save();

        return response()->json($cupon);
    }
    public function show($id)
    {
        $cupon=Coupon::find($id);
        return response()->json($cupon);
    }

    public function update(Request $request, $id)
    {
        $cupon = Coupon::find($id);
        $cupon->nombre = $request->nombre;
        $cupon->codigo = $request->codigo;
        $cupon->stock = $request->stock;
        $cupon->porcentaje = $request->porcentaje;
        $cupon->fechaInicio = $request->fechaInicio ? $request->fechaInicio : null;
        $cupon->fechaFin = $request->fechaFin ? $request->fechaFin : null;
        $cupon->save();
        return response()->json($cupon);
    }

    public function destroy($id)
    {
        if($this->deleteCupon($id))
            return response()->json(['msg'=>'Cupon con ID '.$id.' eliminado.']);
        return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
    }

    public function destroyMultiple(Request $request)
    {
        foreach ($request->ids as $key => $value)
        {
            $status=$this->deleteCupon($value);
            if(!$status)
                break;
        }

        if ($status)
            return response()->json(['msg'=>'Cupones eliminados.']);
        return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
    }

    private function deleteCupon($id)
    {
        $cupon=Coupon::find($id);
        if($cupon->delete())
            return true;
        return false;
    }

    public function buscarCupon(Request $request)
    {
        $data = ['msg'=>'cupon no valido'];
        $hoy = date('Y-m-d');
        $cupon = Coupon::where('codigo',$request->cupon)->where('stock','>','0')->first();
        if($cupon)
        {
            //comprobamos las fechas
            if($cupon->fechaInicio && $cupon->fechaFin  && (date("Y-m-d", strtotime($cupon->fechaInicio)) <= $hoy && date("Y-m-d", strtotime($cupon->fechaFin)) >= $hoy))
            {
                $data = ['msg'=>'cupon valido','cupon'=>$cupon];      	
            }
        }
        return response()->json($data);
    }
}
