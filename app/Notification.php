<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'text', 'user_id', 'icon','type','url',
    ];
}
