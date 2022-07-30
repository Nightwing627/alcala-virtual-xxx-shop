<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function town()
    {
        return $this->belongsTo('App\Town', 'town_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo('App\State', 'state_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail', 'order_id', 'id');
    }
}
