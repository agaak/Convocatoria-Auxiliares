<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulante_conovocatoria extends Model
{
    //
    protected $table='postulante_conovocatoria';

    protected $fillable=['id_postulante', 'id_convocatoria'];
}
