<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'bio_sesion';

    protected $fillable = [  
        'id_bio_camara',
        'id_bio_estadistica',
        'inicio_sesion',
        'fin_sesion'
    ];

    public function camara()
    {
        return $this->belongsTo('App\Camara','id_bio_camara');
    }

    public function estadistica()
    {
        return $this->belongsTo('App\Estadistica','id_bio_estadistica');
    }
}
