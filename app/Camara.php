<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camara extends Model
{
    protected $table = 'bio_camara';

    protected $fillable = [  
        'id_mac',
        'nombre',
        'id_bio_centro',
        'descripcion',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'domingo',
        'id_bio_zona_horaria',
        'amperaje_promedio',
        'mail',
        'voltaje',
        'id_cms_users'
    ];

    public function centro()
    {
        return $this->belongsTo('App\Centro','id_bio_centro');
    }

    public function zonahoraria()
    {
        return $this->belongsTo('App\ZonaHoraria','id_bio_zona_horaria');
    }

    public function estadisticas()
    {
        return $this->hasMany('App\Estadistica','id_bio_camara');
    }
}
