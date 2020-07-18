<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table='area_calificacion';
    protected $fillable=['id_unidad_academica', 'id_tipo_convocatoria', 'nombre'];
}
