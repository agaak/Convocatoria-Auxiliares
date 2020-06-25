<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    //
    protected $table='postulante';
    
    protected $fillable=['nombre', 'apellido', 'carrera', 'correo', 'ci'];
}
