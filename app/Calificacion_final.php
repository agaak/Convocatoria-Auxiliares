<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion_final extends Model
{
    //
    protected $table='calificacion_final';
    protected $fillable=['id_convocatoria', 'porcentaje_merito', 'porcentaje_conocimiento'];
}
