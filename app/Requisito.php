<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    //
    protected $table='requisito';
    
    protected $fillable=['descripcion'];
}
