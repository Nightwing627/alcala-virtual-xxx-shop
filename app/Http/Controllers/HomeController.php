<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Product;
use App\Noticia;
Use App\Category;
use App\Extra;
use Images;

class HomeController extends Controller
{
	
	public function home(){
		return view('page');
	}

	public function admin(){
		return view('admin');
	}

	public function getHome()
	{
		$slider = [];
		$destacados = [];
		$noticias = [];
		$banner = [];
		$cuadros = [];
		$categorias = [];

		$temp = Banner::where('section', 0)->where('status', 1)->orderBy('position', 'ASC')->get();
		foreach($temp as $row){
			$slider[] = [
				'id' => $row->id,
				'imageUrl' => Images::getUrl($row->image_id),
				'device' => $row->device == 1 ? 'pc' : 'movil',
				'url' => $row->url
			];
		}

		$temp = Banner::where('section', 1)->where('status', 1)->get();
		foreach($temp as $row){
			$banner = [
				'id' => $row->id,
				'imageUrl' => Images::getUrl($row->image_id),
				'url' => $row->url
			];
		}

		$temp = Banner::where('section', 2)->where('status', 1)->orderBy('position', 'ASC')->get();
		foreach($temp as $row){
			$cuadros[] = [
				'id' => $row->id,
				'name' => $row->name,
				'imageUrl' => Images::getUrl($row->image_id),
				'url' => $row->url
			];
		}

		$products = Product::take(5)->get();
		foreach($products as $product){
			$destacados[] = [
				'id' => $product->id,
				'sku' => $product->sku,
                'name' => $product->name,
				'price' => $product->price,
				'category' => $product->category->name,
                'img' => Images::getUrl($product->image_id)
            ];
		}

		$news = Noticia::take(3)->get();
		foreach($news as $new){
			$noticias[] = [
                'id' => $new->id,
                'title' => $new->title,
                'body' => $new->body,
                'imageUrl' => Images::getUrl($new->image_id)
            ];
		}

		$data = [
			'banners'    => $slider,
			'secundario' => $banner,
			'cuadros'    => $cuadros,
			'destacados' => $destacados,
			'noticias'   => $noticias,
			'categorias' => $categorias
		];

		return response()->json($data);
	}
}

 ?>