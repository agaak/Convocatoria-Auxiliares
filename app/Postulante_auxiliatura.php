<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulante_auxiliatura extends Model
{
    //
    protected $table='postulante_auxiliatura';

    protected $fillable=['id_postulante', 'id_auxiliatura', 'observacion'];
}
