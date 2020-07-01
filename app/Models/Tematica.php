<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    protected $table='tematica';
    protected $fillable=['id_unidad_academica', 'id_tipo_convocatoria', 'nombre'];
}
