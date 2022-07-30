<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    // use Notifiable;
    use HasRoles;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','celphone','access','image_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function img()
    {
        return $this->hasOne('App\Image','id','image_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Conekta_order','parent_id','token');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id', 'id');
    }
}
