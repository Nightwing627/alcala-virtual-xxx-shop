<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Images;

class ImageController extends Controller
{
    public function get($image_id)
    {
    	$image=Images::getPath($image_id);
    	return response()->file($image);
    }
}
