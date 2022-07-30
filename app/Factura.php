<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public function state()
    {
        return $this->belongsTo('App\State','state_id','id');
    }

    public function town()
    {
        return $this->belongsTo('App\Town','town_id','id');
    }
}
