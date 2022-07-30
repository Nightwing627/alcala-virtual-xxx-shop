<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extra;
use Images;

class ExtrasController extends Controller
{
	public function getPrivacidad()
    {
    	$body = Extra::where('key', 'AVISO_PRIVACIDAD')->first()->value;

    	$data = [
    		'body' => $body,
    		'id' => 11
    	];

    	return response()->json($data);
	}

	public function updatePrivacidad(Request $request)
    {
    	if($request->body)	
    		Extra::where('key', 'AVISO_PRIVACIDAD')->update(['value' => $request->body]);

    	return response()->json(['msg' => "Actualizado correctamente"]);
    }
	
    public function getTerminos()
    {
    	$body = Extra::where('key', 'TERMINOS_CONDICIONES')->first()->value;

    	$data = [
    		'body' => $body,
    		'id' => 8
    	];

    	return response()->json($data);
	}

    public function updateTerminos(Request $request)
    {
    	if($request->body)	
    		Extra::where('key', 'TERMINOS_CONDICIONES')->update(['value' => $request->body]);

    	return response()->json(['msg' => "Actualizado correctamente"]);
    }

    public function getRedes()
    {
    	$facebook = Extra::where('key', 'URL_FACEBOOK')->first()->value;;
		$instagram = Extra::where('key', 'URL_INSTAGRAM')->first()->value;;
		$youtube = Extra::where('key', 'URL_YOUTUBE')->first()->value;;
    	$email = Extra::where('key', 'EMAIL')->first()->value;;
		$telefono = Extra::where('key', 'TELPHONE')->first()->value;;
		$address = Extra::where('key', 'ADDRESS')->first()->value;;

    	$data = [
    		'facebook' => $facebook,
			'instagram' => $instagram,
			'youtube' => $youtube,
    		'email' => $email,
			'telefono' => $telefono,
			'address' => $address
    	];

    	return response()->json($data);
	}

	public function updateRedes(Request $request)
    {

    	if($request->has('facebook'))
    		Extra::where('key', 'URL_FACEBOOK')->update(['value' => $request->facebook]);

    	if($request->has('instagram'))
			Extra::where('key', 'URL_INSTAGRAM')->update(['value' => $request->instagram]);
			
		if($request->has('youtube'))
    		Extra::where('key', 'URL_YOUTUBE')->update(['value' => $request->youtube]);

		if($request->has('email'))
    		Extra::where('key', 'EMAIL')->update(['value' => $request->email]);

		if($request->has('telefono'))
			Extra::where('key', 'TELPHONE')->update(['value' => $request->telefono]);
		
		if($request->has('address'))
    		Extra::where('key', 'ADDRESS')->update(['value' => $request->address]);

    	return response()->json([ "msg" => "ok" ]);
	}
	
	public function getEnvio()
    {
    	$envio = Extra::where('key', 'ENVIO')->first()->value;;
    	return response()->json($envio);
	}
	
	public function updateEnvio(Request $request)
    {
		if($request->has('envio'))
    		Extra::where('key', 'ENVIO')->update(['value' => $request->envio]);

    	return response()->json([ "msg" => "ok" ]);
	}
	
	public function getFaq()
    {
		$body = Extra::where('key', 'FAQ_BODY')->first()->value;;
		
		$data = [
    		'body' => $body,
    	];

    	return response()->json($data);
	}
	
	public function updateFaq(Request $request)
    {
		if($request->has('body'))
			Extra::where('key', 'FAQ_BODY')->update(['value' => $request->body]);

    	return response()->json([ "msg" => "ok" ]);
    }

    public function getNosotros()
    {
    	$historia = Extra::where('key', 'HISTORIA')->first()->value;
    	$nosotros = Extra::where('key', 'NOSOTROS')->first()->value;
		
		$mision = Extra::where('key', 'MISION')->first()->value;
		$vision = Extra::where('key', 'VISION')->first()->value;
		$valores = Extra::where('key', 'VALORES')->first()->value;

    	$data = [
    		'historia' => $historia,
			'nosotros' => $nosotros,
			'mision'   => $mision,
			'vision'   => $vision,
			'valores'  => $valores,
    		'id' => 1,
    		// 'imageUrl' => Images::getUrl($image_id)
    	];

    	return response()->json($data);
    }

    public function updateNosotros(Request $request)
    {
    	if($request->nosotros)	
    		Extra::where('key', 'NOSOTROS')->update(['value' => $request->nosotros]);

    	if($request->historia)	
			Extra::where('key', 'HISTORIA')->update(['value' => $request->historia]);
		
		if($request->mision)	
			Extra::where('key', 'MISION')->update(['value' => $request->mision]);

    	if($request->vision)	
			Extra::where('key', 'VISION')->update(['value' => $request->vision]);
		
		if($request->valores)	
			Extra::where('key', 'VALORES')->update(['value' => $request->valores]);

    	// if($request->image)
    	// {
    	// 	$image_id = Extra::where('key', 'EMPRESA_IMG_ID')->first()->value;
    		
    	// 	if($image_id != 1 && $image_id != 2)
    	// 		Images::delete($image_id);

    	// 	$image_id = Images::save($request->image);
    		
    	// 	Extra::where('key', 'EMPRESA_IMG_ID')->update(['value' => $image_id]);	
    	// }

    	return response()->json(['msg' => "Actualizado correctamente"]);
	}
	
	private function guardarImagen($image_id, $imagen)
	{
		if($image_id != 1 && $image_id != 2){
			Images::delete($image_id);
		}

		$image_id = Images::save($imagen);
		
		return $image_id;
	}

	public function getGarantia()
    {
		$body = Extra::where('key', 'GARANTIA_BODY')->first()->value;;
		
		$data = [
    		'body' => $body,
    	];

    	return response()->json($data);
	}
	
	public function updateGarantia(Request $request)
    {
		if($request->has('body'))
			Extra::where('key', 'GARANTIA_BODY')->update(['value' => $request->body]);

    	return response()->json([ "msg" => "ok" ]);
    }

	public function getPagos()
    {
		$body = Extra::where('key', 'PAGOS_BODY')->first()->value;;
		
		$data = [
    		'body' => $body,
    	];

    	return response()->json($data);
	}
	
	public function updatePagos(Request $request)
    {
		if($request->has('body'))
			Extra::where('key', 'PAGOS_BODY')->update(['value' => $request->body]);

    	return response()->json([ "msg" => "ok" ]);
    }
}
