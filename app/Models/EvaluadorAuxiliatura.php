<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluadorAuxiliatura extends Model
{
    //
    protected $table='evaluador_auxiliatura';

    protected $fillable=['id_evaluador_convocatoria', 'id_auxiliatura'];
}
