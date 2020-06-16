<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use Illuminate\Support\Facades\DB;

class RequerimientoComp
{   
    public function getRequerimientos($id_conv){
        $requests=DB::table('requerimiento')->select('requerimiento.*','nombre_aux','cod_aux')
        ->join('auxiliatura','requerimiento.id_auxiliatura', '=','auxiliatura.id')
        ->where('requerimiento.id_convocatoria',$id_conv)
        ->get();
        return $requests;
    }
}
