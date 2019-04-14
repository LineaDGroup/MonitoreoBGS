<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZonaHoraria extends Model
{
    protected $table = 'bio_zona_horaria';

    protected $fillable = [  
        'zona',
        'lugar',
        'hora'
    ];

    public function camaras()
    {
        return $this->hasMany('App\Camara','id_bio_zona_horaria');
    }
}
