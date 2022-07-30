<?php

namespace App\Http\Controllers;

use App\Noticia;
use Images;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = Noticia::all();
        
        $data=[];
        
        foreach ($news as $key => $value) {
            $value->image=Images::getImg($value->image_id);
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
        $news = new Noticia();
        $news->title = $request->title; 
        $news->body= $request->body; 
        
        if($request->image){
            $image_id=Images::save($request->image);
            $news->image_id = $image_id;
        }

        $news->save();
        $news->img;

        return $news;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $new = Noticia::find($id);
        
        $data = [
            'title' => $new->title,
            'body' => $new->body,
            'id' => $new->id,
            'imageUrl' => Images::getUrl($new->image_id),
            'fecha' => $new->created_at->format('d-m-Y H:i')
        ];
        //$news->imageUrl = Images::getUrl($news->image_id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news = Noticia::find($id);
        $news->title = $request->title;
        $news->body = $request->body;

        if(isset($request->image)){
            //borrar la imagen anterior
            Images::delete($news->image_id);
            
            //Subimos la nueva imagen
            $image_id=Images::save($request->image);
            $news->image_id = $image_id;
        }

        $news->save();

        $news->img;

        return response()->json($news->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->_deleteNews($id)){
            return response()->json(['msg'=>'Noticia con ID '.$id.' eliminado.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    public function destroyMultiple(Request $request)
    {
        foreach ($request->ids as $key => $value) {
            $status=$this->_deleteNews($value);
            if(!$status)
                break;
        }

        if ($status) {
            return response()->json(['msg'=>'Noticias eliminadas.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    private function _deleteNews($id)
    {
        $news = Noticia::find($id);
        $news->img;
        if($news->img->key!="default"){
            Images::delete($news->img->id);
        }
        if ($news->delete()) {
            return true;
        }
        else{
            return false;
        }
    }

    public function getNews()
    {
        $news = Noticia::take(9)->get();
        $data = [];
        foreach($news as $new){
            $data[] = [
                'title' => $new->title,
                'body' => $new->body,
                'id' => $new->id,
                'imageUrl' => Images::getUrl($new->image_id),
                'fecha' => $new->created_at->format('d-m-Y H:i')
            ];
        }
        return $data;
    }
}
