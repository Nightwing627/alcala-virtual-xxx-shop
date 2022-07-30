<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Modelo de usuario
use App\User;
use App\Customer;

//Modelo de imagenes
// use App\Image;

//Validador de peticiones
use App\Http\Requests\UserFormRequest;
//Manejo de archivos
use Illuminate\Support\Facades\Storage;
//Has para contraseñas
use Illuminate\Support\Facades\Hash;
//Servicios de imagenes
use Images;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperarContra;

class UsersController extends Controller
{
    private $disk='images_users';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        $data=[];
        foreach ($users as $key => $value) {
            $value->image=Images::getImg($value->image_id);
            
            $value['types']=$value->getRoleNames();                
            
            array_push($data, $value);
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        
        $user=new User(array(
            'email'=>$request->email,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'celphone'=>$request->celphone,
            'access'=>$request->access,
        ));

        
        
        if($request->image){
            $image_id=Images::save($request->image,"users");
            $user->image_id=$image_id;
        }

        $user->save();
        $user->syncRoles($request->roles);
        $user->save();

        $user->img;

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id);
        $user->imageUrl=Images::getUrl($user->image_id);
        $user->getRoleNames();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        // var_dump($request->all());
        // die();
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->celphone=$request->celphone;
        $user->access=$request->access;

        if(isset($request->password)){
            $user->password=Hash::make($request->password);
        }

        $user->syncRoles($request->roles);

        if(isset($request->image)){
            if ($user->image_id!=1 && $user->image_id!=2) {
                //Borramos la imagen anterior
                Images::delete($user->image_id);
            }
            
            //Subimos la nueva imagen
            $image_id=Images::save($request->image);
            $user->image_id=$image_id;
        }

        $user->save();

        $user->img;

        return response()->json($user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

     //Metodos para el front
     public function nuevo(Request $request)
     {
         if(User::where('email',$request->email)->first())
             return response()->json(['status' => 402, "msg" => "El correo que colocó ya esta siendo utilzado"]);
 
         $user = new User();
         $user->email = $request->email;
         $user->name = $request->name;
         $user->lastname = $request->lastname;
         $user->password = Hash::make($request->password);
         $user->access = 0;
         $user->save();
         $user->syncRoles(['cliente']);

         $customer = new Customer();
         $customer->user_id = $user->id;
         $customer->save();
 
         try
         {
             if(!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password]))
                 return response()->json(["error"=>"Credenciales invalidas"],500);
         }
         catch (JWTException $e)
         {
             return response()->json(["error"=>"Ocurrio un error en el servidor."],500);
         }
         //Esto solo se ejecutara en caso de que las credenciales sean correctas.
         $user = Auth::user();
         $user->imageUrl = Images::getUrl($user->image_id);
         $user->customer;
 
         $response = ['status' => 200, 'token' => "Bearer ".$token, 'user'=>$user];
 
         return $response;        
     }
 
     public function changePass(Request $request)
     {
         $user = JWTAuth::authenticate();
 
         try {
             if(!JWTAuth::attempt(['email' => $user->email, 'password' => $request->password])){
                 return response()->json(['status' => 402, "msg" => "Contraseña incorrecta"]);              
             }
         } catch (JWTException $e) {
             //Respuesta en cualquier error del servidor
             return response()->json(["error"=>"Ocurrio un error en el servidor."],500);
         }
 
         $user->password = Hash::make($request->npassword);
         $user->save();
         return response()->json(['status' => 200, "msg" => "Contraseña actualizada correctamente"]);
     }
 
     public function guardarCambios(Request $request){
 
         $user = JWTAuth::authenticate();
 
         if(User::where('email',$request->email)->where('id','<>',$user->id)->first())
             return response()->json(['status' => 402, 'msg' => "Correo en uso"]);
 
         if($request->image)
         {
             if($user->image_id != 1 && $user->image_id != 2)
                 Images::delete($user->image_id);
             $user->image_id = Images::save($request->image, "users");
         }
         
         $user->name = $request->name;
         $user->lastname = $request->lastname;
         $user->email = $request->email;
         $user->phone = $request->phone;
         $user->save();

         $user->customer->fill($request->all());
         $user->customer->save();
 
         $i = Images::getURL($user->image_id,'100/100');
 
         return response()->json(['status' => 200 , 'msg' => 'Cambios guardados con exito', 'imageUrl' => $i,'user'=>$user]);
     }
 
     public function getOrders($id)
     {
         $token = JWTAuth::getToken();
 
         if(!$token)
             return response()->json(["msg" => "Se necesita un token", 400]);
 
         $user = JWTAuth::authenticate();
         $pedidos = Pedido::where('users_id', $id)->orderBy('id', 'desc')->get();
         /*$pedidos = $user->pedidos;*/
 
 
         foreach ($pedidos as $key => &$value) {
             
             //$value->imgUrl = $value->imagen;
             $value->nombres = $value->nombres_productos;
             $value->estado = $value->status;
         }
 
         return response()->json($pedidos);
     }
 
     public function getDetail($order_id)
     {
         $token = JWTAuth::getToken();
 
         if(!$token)
             return response()->json(["msg" => "Se necesita un token", 400]);
 
         $user = JWTAuth::authenticate();
         $pedido = Pedido::where('id', $order_id)->where('users_id', $user->id)->first();
 
         if(!empty($pedido))
         {
             $detalles = $pedido->detalles;
             foreach ($detalles as $key => &$value) {
                 $value->imagen = "";
                 if(isset($value->producto->imagenes[0]))
                     $value->imagen = Images::getUrl($value->producto->imagenes[0]->id);
                 
                 $value->producto;
                 $value->has_talla->talla;
                 $value->color = Images::getUrl($value->producto->color->imagen_id);
             }
 
             return response()->json($detalles);
         }
 
         return response()->json(['No se encontro al pedido'], 400);
     }

     //Recuperacion de contraseña
     public function recuperarContra(Request $request)
     {
         $usuario = User::where('email',$request->correo)->first();
         if($usuario)
         {
             $password = str_random(8);
             $usuario->password = Hash::make($password);
             $usuario->save();
 
             $inputs =  array('name' => $usuario->name, 'email' => $usuario->email, 'password' => $password);
             Mail::to($usuario->email)->queue(new RecuperarContra($inputs));
 
         }
         return response()->json(['msg' => 200]);
     }

}
