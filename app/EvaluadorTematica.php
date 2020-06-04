<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluadorTematica extends Model
{
    //
    protected $table='evaluador_tematica';

    protected $fillable=['id_evaluador', 'id_tematica'];
}
