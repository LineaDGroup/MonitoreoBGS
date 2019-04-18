<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    protected $table = 'bio_estadistica';

    protected $fillable = [  
        'id_bio_camara',
        'ip',
        'fecha',
        'hora',
        'voltaje',
        'consumo',
        'free'
    ];

    protected $with = [];

    // protected $appends = ['countSesiones'];

    public function camara()
    {
        return $this->belongsTo('App\Camara','id_bio_camara');
    }

    public function sesiones()
    {
        return $this->hasMany('App\Sesion','id_bio_estadistica');
    }

    public function getCountSesionesAttribute() 
    {
        return $this->sesiones->count();
    }


}
