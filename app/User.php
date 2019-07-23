<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'cms_users';

    protected $fillable = [ 'name', 'email', 'password','status', 'id_bio_centro' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        if(!isset($this->api_token)) {
            $this->api_token = str_random(60);
            $this->save();
        }
        return $this->api_token;
    }

    public function centro()
    {
        return $this->belongsTo('App\Centro','id_bio_centro');
    }

    public function camaras()
    {
        return $this->hasMany('App\Camara','id_cms_users');
    }


}
