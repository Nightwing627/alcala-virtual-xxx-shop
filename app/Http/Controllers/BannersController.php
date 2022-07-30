<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BannerFormRequest;
use App\Banner;
use Images;

class BannersController extends Controller
{
    public function index()
    {
	    $banners = Banner::all();
	    foreach ($banners as $key => $value)
	    {	
	        $value->imagen = Images::getImg($value->image_id);
          	$value->device = ($value->device)?("PC"):("Celular");
	        $value->status = ($value->status)?("Si"):("No");
	    }
	    return response()->json($banners);
    }

    public function indexFront()
    {
    	$bannersPC = Banner::where('section',0) //Seccion 0 es para banner principal
    					   ->where('device',1)  //1 para banners para pc
    					   ->where('status',1)  //1 para banners activos
    					   ->orderBy('position','ASC')
    					   ->get();

    	$bannersMovil = Banner::where('section',0)
    						  ->where('device',0)
    						  ->where('status',1)
    						  ->orderBy('position','ASC')
    						  ->get();

      $bannersSecundarios = Banner::where('section','<>',0)
                                  ->where('status',1)
                                  ->orderBy('section','ASC')
                                  ->get();

    	foreach ($bannersPC as $key => $value)
    		$value->imagen = Images::getUrl($value->image_id);

    	foreach ($bannersMovil as $key => $value)
    		$value->imagen = Images::getUrl($value->image_id);

      foreach ($bannersSecundarios as $key => $value)
        $value->imagen = Images::getUrl($value->image_id);

    	return response()->json(['pc' => $bannersPC, 'movil' => $bannersMovil, 'secundarios' => $bannersSecundarios]);
    }
    
    public function store(BannerFormRequest $request)
    {
      $banner = new Banner();
      $banner->name = $request->name;

      if($request->section)
        $banner->section = $request->section;  
      else
      {
        $banner->device = $request->device ? 1 : 0 ;
        $banner->position = $request->position ? $request->position : 0;
      }

      $banner->url = $request->url;
      $banner->status = ($request->status) ? 1 : 0 ;

      if($request->image)
          $banner->image_id = Images::save($request->image);

      $banner->save();
      return response()->json($banner);
    }

    public function show($id)
    {
      $banner = Banner::find($id);
      $banner->imageUrl = Images::getUrl($banner->image_id);
      $banner->device = $banner->device ? true : false;
      return response()->json($banner);
    }

    public function update(BannerFormRequest $request, $id)
    {
	    $banner = Banner::find($id);
	    $banner->name = $request->name;

      if($request->section)
        $banner->section = $request->section;  
      else
      {
        $banner->device = $request->device ? 1 : 0 ;
        $banner->position = $request->position ? $request->position : 0;
      }

	    $banner->url = $request->url;
	    $banner->status = ($request->status) ? 1 : 0 ;

	    if($request->image)
	    {
            if ($banner->image_id != 2 && $banner->image_id != 1)
            	Images::delete($banner->image_id);
        	$banner->image_id = Images::save($request->image);
    	}

      $banner->save();
      
      return response()->json($banner->id);
    }

    public function destroy($id)
	{
	   if($this->_deleteBanner($id)){
	       return response()->json(['msg'=>'Banner con ID '.$id.' eliminado.']);
	   }
	   else{
	       return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
	   }
	}

	public function destroyMultiple(Request $request)
	{
		foreach ($request->ids as $key => $value) {
			$status=$this->_deleteBanner($value);
			if(!$status)
		     	break;
		}

		if ($status) {
			return response()->json(['msg'=>'Banners eliminados.']);
		}
		else{
			return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
		}
	}

	private function _deleteBanner($banner_id)
	{
	    $banner = Banner::find($banner_id);
	    if($banner->image_id != 2 && $banner->image_id != 1)
        	Images::delete($banner->image_id);
	    if($banner->delete())
	      	return true;
	   	return false;
	}

}
