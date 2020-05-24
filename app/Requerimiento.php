<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    //
    protected $table='requerimiento';

    protected $fillable=['id_convocatoria','nombre','item','cantidad','horas_mes','cod_aux'];    
}
