<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $contacts = Contact::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( empty($request->name) OR empty($request->email) OR empty($request->msg) ){
            return response()->json(['response'=>'Falta campos por llenar']);
          }
        
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone ? $request->phone : null;
        $contact->message = $request->msg;
        $contact->save();

        Mail::to('ventas@vsexshopgdlalcala.com.mx')->queue(new ContactMail($contact));

        return response()->json(['response'=>'Gracias por enviarnos su mensaje, nos contactaremos con usted a la brevedad posible.']);
    }
}
