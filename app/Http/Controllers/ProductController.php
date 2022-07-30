<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Subcategory;
use Illuminate\Http\Request;

use Images;
use Documents;
use Carbon\Carbon;

use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category', 'subcategory')->get();

        $data=[];
        foreach ($products as $key => $value) {
            $value->image = Images::getImg($value->image_id);
            array_push($data, $value);
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->weight = $request->weight;
        $product->measure = $request->measure;
        $product->tags = $request->tags;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id; 

        if($request->image){
            $image_id = Images::save($request->image);
            $product->image_id = $image_id;
        }

        if($request->video){
            $product->document_id = Documents::save($request->video);
        }

        $product->save();
        $product->img;

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $product->imageUrl = Images::getUrl($product->image_id);
        $product->videoUrl = Documents::getUrl($product->document_id);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->weight = $request->weight;
        $product->measure = $request->measure;
        $product->tags = $request->tags;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;     

        if(isset($request->image)){
            if ($product->image_id != 1 && $product->image_id != 2) {
                //Borramos la imagen anterior
                Images::delete($product->image_id);
            }
            //Subimos la nueva imagen
            $image_id = Images::save($request->image);
            $product->image_id = $image_id;
        }

        if($request->video){
            if($product->document_id != null){
                Documents::delete($product->document_id);
            }
            $product->document_id = Documents::save($request->video);
        }

        $product->save();

        return response()->json($product);
    }

    public function import(Request $request)
    {
        try{
            Excel::import(new ProductsImport, request()->file('file'));
            return response()->json(['msg'=>'La importación ha finalizado exitosamente!.']);   

        }catch (\Exception $e) {
            return $e;
            return response()->json(['msg'=>'Ocurrio un error', 'error' => $e],500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
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
        $temp = Product::find($id);
        $temp->img;

        if($temp->img->key != "default" && $temp->img->key != "logo"){
            Images::delete($temp->img->id);
        }

        if ($temp->delete()) {
            return true;
        }
        else{
            return false;
        }
    }

    public function export()
    {
        ini_set('memory_limit', '-1');
        return Excel::download(new ProductsExport, 'Productos-'.date('dmY').'.xlsx');
    }

    /* Métodos de galeria del producto */
    public function getImages($id)    
    {
        $producto = Product::find($id);
        $images = $producto->images;   
        if(count($images)>0)
            foreach ($images as $key => &$image)
                $image['url'] = Images::getUrl($image->id);
        return response()->json($images);
    }

    public function uploadImage(Request $request, $id)
    {
        $producto = Product::find($id);
        if($request->has('file'))
        {   
            $file = $request->file('file');
            $image_id = Images::save($file);
            $producto->images()->attach($image_id);
        }    
        return response()->json('imagen cargada!');
    }

    public function deleteImage($id)
    {
        Images::delete($id); //El registro de la tabla pivote se muere en cascada, asi que no es necesario eliminarlo
        return response()->json(array("msg" => 'Se eliminó la imagen correctamente'));
    }

    //front
    public function getProducts()
    {
        $data = [];
        $products = Product::select('id','sku','name','description','price','category_id','subcategory_id','image_id')->paginate(50);
        foreach($products as $product){
            $product->category = $product->category->name;
            $product->img = Images::getUrl($product->image_id);
        }
        return response()->json($products);
    }

    public function search(Request $request)
    {
        $data = [];
        $keywords = $request->keywords;
        $products = Product::where(function($query) use($keywords){
                        $query->orWhere('name', 'like', '%'.$keywords.'%')
                        ->orWhere('sku', 'like', '%'.$keywords.'%')
                        ->orWhere('tags', 'like', '%'.$keywords.'%')
                        ->orWhere('description', 'like', '%'.$keywords.'%');
                    })->select('id','sku','name','description','price','category_id','subcategory_id','image_id');
        
        if($request->precios){

            switch($request->precios)
            {
                case 1: $min = 0; $max = 900; break;
                case 2: $min = 901; $max = 1900; break;
                case 3: $min = 1901; $max = 3000; break;
                case 4: $min = 3001; $max = 4000; break;
                case 5: $min = 4001; $max = 5000; break;
            }

            $productos = $products->where('price','>',$min)->where('price','<',$max)->paginate(50);

        }else{
            $productos = $products->paginate(50);
        }

        foreach ($productos as $key => $product)
        {
            $product->category = $product->category->name;
            $product->img = Images::getUrl($product->image_id);
        }

        return response()->json($productos);
    }

    public function getProductsCategory($id)
    {
        $data = [];
        $category = Category::find($id);
        $products = Product::where('category_id', $category->id)->get();
        foreach($products as $product){
			$data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->category->name,
                'img' => Images::getUrl($product->image_id)
            ];
        }
        return response()->json(['products' => $data, 'category' => $category]);
    }

    public function getProductsCategoryFilters(Request $request, $id)
    {
        $data = [];
        $category = Category::find($id);

        if($request->precios){

            switch($request->precios)
            {
                case 1: $min = 0; $max = 900; break;
                case 2: $min = 901; $max = 1900; break;
                case 3: $min = 1901; $max = 3000; break;
                case 4: $min = 3001; $max = 4000; break;
                case 5: $min = 4001; $max = 5000; break;
            }

            $products = Product::where('category_id', $category->id)->where('price','>',$min)->where('price','<',$max)->get();

        }else{
            $products = Product::where('category_id', $category->id)->get();
        }

        foreach($products as $product){
			$data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category->name,
                'img' => Images::getUrl($product->image_id)
            ];
        }
        return response()->json(['products' => $data, 'category' => $category]);
    }

    public function getProductsSubcategory($id)
    {
        $data = [];
        $category = Subcategory::find($id);
        $products = Product::where('subcategory_id', $category->id)->get();

        foreach($products as $product){
			$data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->category->name,
                'img' => Images::getUrl($product->image_id)
            ];
        }

        return response()->json(['products' => $data, 'category' => $category]);
    }

    public function getProductsSubcategoryFilters(Request $request, $id)
    {
        $data = [];
        $category = Subcategory::find($id);

        if($request->precios){

            switch($request->precios)
            {
                case 1: $min = 0; $max = 900; break;
                case 2: $min = 901; $max = 1900; break;
                case 3: $min = 1901; $max = 3000; break;
                case 4: $min = 3001; $max = 4000; break;
                case 5: $min = 4001; $max = 5000; break;
            }

            $products = Product::where('subcategory_id', $category->id)->where('price','>',$min)->where('price','<',$max)->get();

        }else{
            $products = Product::where('subcategory_id', $category->id)->get();
        }

        foreach($products as $product){
			$data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category->name,
                'img' => Images::getUrl($product->image_id)
            ];
        }
        return response()->json(['products' => $data, 'category' => $category]);
    }

    public function relacionados(Request $request, $category_id)
    {
        $products = Product::where('category_id', $category_id)->with('category')->take(5)->get();

        foreach ($products as $key => $value) {
            $value->image = Images::getUrl($value->image_id);
        }

        return response()->json($products);
    }

    public function frontShow($id)
    {
        $producto = Product::with('category')->find($id);
        if($producto){
            $producto->imageUrl = Images::getUrl($producto->image_id);
            $producto->video = $producto->document_id ? Documents::getUrl($producto->document_id) : null;
            //obtener las multiples imagenes
            $gallery = [];
            $multipleImages = $producto->images;   
            if($multipleImages){
                foreach ($multipleImages as $multipleImage){
                    $gallery[] = Images::getUrl($multipleImage->id);
                }
            }

            $producto->gallery = $gallery;
        }
         return response()->json($producto);
    }
}
