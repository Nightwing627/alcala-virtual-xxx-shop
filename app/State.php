<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function towns()
    {
    	return $this->hasMany('App\Town','state_id');
    }
}
