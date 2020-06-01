<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    //
    protected $table='postulante';
    
    protected $fillable=['nombre', 'apellido', 'carrera', 'correo', 'ci'];
}
