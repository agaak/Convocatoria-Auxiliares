<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    //
    protected $table='requerimiento';

    protected $fillable=['horas_mes', 'cant_aux'];
}
