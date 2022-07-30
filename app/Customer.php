<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'street', 'num_ext', 'num_int', 'neighborhood', 'postalCode', 'state_id', 'town_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
