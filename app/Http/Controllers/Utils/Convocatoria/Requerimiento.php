<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\Requerimiento;

class Requerimiento
{   
    public function getRequerimientos($id_conv){
        $requests=Requerimiento::select('requerimiento.*','nombre_aux','cod_aux')
        ->join('auxiliatura','requerimiento.id_auxiliatura', '=','auxiliatura.id')
        ->where('requerimiento.id_convocatoria',$id_conv)
        ->get();
        return $requests;
    }
}
