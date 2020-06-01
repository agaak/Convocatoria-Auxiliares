<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluador_auxiliatura extends Model
{
    //
    protected $table='evaluador_auxiliatura';

    protected $fillable=['id_evaluador', 'id_auxiliatura'];
}
