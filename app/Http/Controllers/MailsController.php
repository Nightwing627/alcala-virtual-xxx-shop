<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

use Redirect;
use Validator;

class MailsController extends Controller
{

  public function contact(Request $request)
  {
    $data=$request->all();

    if( empty($data['name']) OR empty($data['email']) OR empty($data['msg']) ){
      return response()->json(['response'=>'Falta campos por llenar']);
    }

    foreach ($data as $key => $value) {
      $data[$key] = strip_tags($data[$key]);
    }

    $data['phone'] = (empty($data['phone'])) ? '-' : $data['phone'];

    $niceNames = array(
      'name' => 'Nombre',
      'email' => 'Correo electrónico',
      'phone' => 'Teléfono',
      'msg' => 'Mensaje',
    );
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'phone' => 'nullable|digits_between:8,10',
      'msg' => 'required',
    ]);
    $validator->setAttributeNames($niceNames);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 400);
    }

    Mail::send('emails.contact',(array)$data,function($m) use ($data){
      $m->from('no-reply@xxxx.com', $name = 'Queen Sense');
      $m->to('no-reply@xxxx.com');
	    $m->subject('Queen Sense | Formulario de contacto');
		});

    if( count(Mail::failures()) > 0 ) {
      return response()->json(['name'=> [0 => 'Error. Try again'] ], 400);
    }

    return response()->json(['response'=>'Gracias por enviarnos su mensaje, nos contactaremos con usted a la brevedad posible.']);
  }
}
