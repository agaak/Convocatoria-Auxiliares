<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluadorConovocatoria extends Model
{
    //
    protected $table='evaluador_conovocatoria';

    protected $fillable= ['id_evaluador', 'id_convocatoria'];
}
