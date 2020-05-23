<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{

    



 
    protected $table= 'convocatoria';

    protected $fillable= ['id_unidad_academica', 'titulo_conv', 'descripcion_conv', 'fecha_ini', 'fecha_fin'];
}
