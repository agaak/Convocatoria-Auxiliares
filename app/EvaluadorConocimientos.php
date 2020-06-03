<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluadorConocimientos extends Model
{
    //
    protected $table='evaluador_conocimientos';

    protected $fillable=['ci', 'nombre', 'apellido', 'correo'];
}
