<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_evaluador extends Model
{
    //
    protected $table='tipo_evaluador';
    protected $fillable=['id_rol_evaluador', 'id_evaluador_convocatoria'];

}
