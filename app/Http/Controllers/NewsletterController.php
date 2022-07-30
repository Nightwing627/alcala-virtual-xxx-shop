<?php

namespace App\Http\Controllers;

use App\Newsletter;
use Illuminate\Http\Request;
use App\Exports\NewsletterExport;
use Excel;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Newsletter::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( empty($request->email) ){
            return response()->json(['response'=>'Falta campos por llenar']);
          }
        
        $contact = new Newsletter();
        $contact->email = $request->email;
        $contact->save();

        return response()->json(['response'=>'Gracias por registrarte en nuestro Newsletter.']);
    }

    public function export()
    {
        ini_set('memory_limit', '-1');
        return Excel::download(new NewsletterExport, 'Newsletter.xlsx');
    }
}
