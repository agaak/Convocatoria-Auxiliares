<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluadorAuxiliatura extends Model
{
    //
    protected $table='evaluador_auxiliatura';

    protected $fillable=['id_evaluador', 'id_auxiliatura'];
}
