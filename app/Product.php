<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function img()
    {
        return $this->hasOne('App\Image','id','image_id');
    }

    public function images()
    {
    	return $this->belongsToMany('App\Image', 'product_images', 'product_id', 'image_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory', 'subcategory_id', 'id');
    }


}
