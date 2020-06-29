<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auxiliatura extends Model
{
    protected $table='auxiliatura';
    protected $fillable=['id_unidad_academica', 'id_tipo_convocatoria', 'nombre_aux', 'cod_aux'];
}
