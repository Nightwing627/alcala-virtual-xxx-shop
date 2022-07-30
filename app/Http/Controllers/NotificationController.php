<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notifications;
use App\Notification;

//Validador de peticiones
use App\Http\Requests\NotificationFormRequest;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $notifications=Notification::latest()->take(10)->get();

        return response()->json($notifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resume($user_id)
    {
        $notifications=Notification::where('readed',false)->get();
        if(empty($notifications)){
            $notifications=Notification::take(4)->get();
        }
        $notifications=Notification::latest()->take(4)->get();

        return response()->json($notifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function readAll($user_id)
    {
        Notifications::readAll($user_id);

        return response()->json(['msg'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationFormRequest $request)
    {
        $notification=Notifications::new($request);

        return response()->json($notification);
    }

}
