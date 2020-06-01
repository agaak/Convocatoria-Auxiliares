<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluador_conovocatoria extends Model
{
    //
    protected $table='evaluador_conovocatoria';

    protected $fillable= ['id_evaluador', 'id_convocatoria'];
}
