<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Images;
use Documents;

class MediaController extends Controller
{
    public function getImage($image_id)
    {
    	$image=Images::getPath($image_id);
    	return response()->file($image);
    }

    public function getDocument($doc_id)
    {
    	$doc=Documents::getPath($doc_id);
    	return response()->file($doc);
    }
}
