<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function subMenus()
    {
    	return $this->hasMany('App\Menu','parent');
    }
}
