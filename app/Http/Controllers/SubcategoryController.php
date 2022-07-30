<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Category;
use Images;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Subcategory::orderBy('name', 'asc')->get();
    }

    public function store(Request $request)
    {
        $subcategoria = new Subcategory();
        $subcategoria->name = $request->name;
        $subcategoria->category_id = $request->category_id ? $request->category_id : null;

        if($request->image){
            $image_id=Images::save($request->image);
            $subcategoria->image_id = $image_id;
        }

        $subcategoria->save();

        return $subcategoria;
    }

    public function show($id)
    {
        $subcategoria = Subcategory::find($id);
        $subcategoria->imageUrl = Images::getUrl($subcategoria->image_id);
        return $subcategoria;
    }

    public function update(Request $request, $id)
    {
        $subcategoria = Subcategory::find($id);
        $subcategoria->name = $request->name;
        $subcategoria->category_id = $request->category_id ? $request->category_id : null;

        if(isset($request->image)){
            if ($subcategoria->image_id && $subcategoria->image_id != 1 && $subcategoria->image_id != 2) {
                //Borramos la imagen anterior
                Images::delete($subcategoria->image_id);
            }
            //Subimos la nueva imagen
            $image_id = Images::save($request->image);
            $subcategoria->image_id = $image_id;
        }

        $subcategoria->save();

        return $subcategoria;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $subcategoria
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
        $temp = Subcategory::find($id);

        if ($temp->delete()) {
            return true;
        }
        else{
            return false;
        }
    }

    public function getSubcategories($id)
    {
        $data = [];
        $category = Category::find($id);
        if($category){
            $category->imageUrl = Images::getUrl($category->image_id);
            $subcategories = Subcategory::where('category_id', $category->id)->get();
            foreach($subcategories as $subcategory){
                $data[] = [
                    'id'   => $subcategory->id,
                    'name' => $subcategory->name,
                    'img'  => Images::getUrl($subcategory->image_id)
                ];
            }
        }

        return ['subcategories' => $data, 'category' => $category];
    }
}
