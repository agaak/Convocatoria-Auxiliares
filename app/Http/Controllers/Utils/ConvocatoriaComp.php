<?php

namespace App\Http\Controllers\Utils;

use App\Convocatoria;

class ConvocatoriaComp
{   
    public function getConvocatorias(){
        $requests= Convocatoria::where('id_unidad_academica',1)->get();
        return $requests;
    }

    public function getConvocatoriasPublicas(){
        $requests= Convocatoria::where('id_unidad_academica',1)
        ->where('publicado',true)
        ->get();
        return $requests;
    }
}
