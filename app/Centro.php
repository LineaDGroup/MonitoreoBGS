<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'bio_centro';

    protected $fillable = [  
        'descripcion'
    ];

    public function camaras()
    {
        return $this->hasMany('App\Camara','id_bio_centro');
    }


}
