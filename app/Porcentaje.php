<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porcentaje extends Model
{
    //
    protected $table= 'porcentaje';

    protected $fillable= ['id_requerimiento','id_tematica','porcentaje'];
}
