<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = User::role('cliente')->get();
        return $customer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User(array(
            'email' => $request->email,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'celphone' => $request->celphone,
            'access' => 0,
        ));

        $user->save();
        $user->syncRoles('cliente');
        $user->img;

        $customer = new Customer();
        $customer->user_id = $user->id;
        $customer->street = $request->street;
        $customer->num_ext = $request->num_ext;
        $customer->num_int = $request->num_int;
        $customer->neighborhood = $request->neighborhood;
        $customer->postalCode = $request->postalCode;
        $customer->state_id = $request->state_id;
        $customer->town_id = $request->town_id;
        $customer->save();
        
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::role('cliente')->where('id', $id)->first();
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->celphone = $request->celphone;

        if(isset($request->password)){
            $user->password=Hash::make($request->password);
        }
        
        $user->save();

        $customer = Customer::where('user_id', $id);
        $customer->street = $request->street;
        $customer->num_ext = $request->num_ext;
        $customer->num_int = $request->num_int;
        $customer->neighborhood = $request->neighborhood;
        $customer->postalCode = $request->postalCode;
        $customer->state_id = $request->state_id;
        $customer->town_id = $request->town_id;
        $customer->save();

        return response()->json($user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->_deleteUser($id)){
            return response()->json(['msg'=>'Usuario con ID '.$id.' eliminado.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    public function destroyMultiple(Request $request)
    {
        foreach ($request->ids as $key => $value) {
            $status=$this->_deleteUser($value);
            if(!$status)
                break;
        }

        if ($status) {
            return response()->json(['msg'=>'Usuarios eliminados.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    private function _deleteUser($user_id)
    {
        $user=User::find($user_id);
        $user->img;
        
        if($user->img->key!="default" && $user->img->key!="logo"){
            Images::delete($user->img->id);
        }
        if ($user->delete()) {
            return true;
        }
        else{
            return false;
        }
    }
}
