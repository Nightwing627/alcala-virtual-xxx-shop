<?php

namespace App\Http\Controllers;

use App\Category;
use Images;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('name', 'asc')->get();
        return $category; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new Category();
        $categoria->name = $request->name;

        if($request->image){
            $image_id=Images::save($request->image);
            $categoria->image_id = $image_id;
        }

        $categoria->save();

        return $categoria;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Category::find($id);
        if($categoria->image_id){
            $categoria->imageUrl = Images::getUrl($categoria->image_id);
        }
        return $categoria;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Category::find($id);
        $categoria->name = $request->name;

        if(isset($request->image)){
            if ($categoria->image_id && $categoria->image_id != 1 && $categoria->image_id != 2) {
                //Borramos la imagen anterior
                Images::delete($categoria->image_id);
            }
            //Subimos la nueva imagen
            $image_id = Images::save($request->image);
            $categoria->image_id = $image_id;
        }
        
        $categoria->save();

        return $categoria;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->_delete($id)){
            return response()->json(['msg'=>'registro con ID '.$id.' eliminado.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    public function destroyMultiple(Request $request)
    {
        foreach ($request->ids as $key => $value) {
            $status=$this->_delete($value);
            if(!$status)
                break;
        }

        if ($status) {
            return response()->json(['msg'=>'Registros eliminados.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    private function _delete($id)
    {
        $temp = Category::find($id);

        if ($temp->delete()) {
            return true;
        }
        else{
            return false;
        }
    }
}
