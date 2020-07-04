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

    public function getRequerimientos2($id_conv){
        $requests=DB::table('requerimiento')->select('requerimiento.id_auxiliatura as id_aux',
        'nombre_aux as nombre','cod_aux','porcentaje.id as id')
        ->join('auxiliatura','requerimiento.id_auxiliatura', '=','auxiliatura.id')
        ->join('porcentaje','porcentaje.id_requerimiento','=','requerimiento.id')
        ->where('requerimiento.id_convocatoria',$id_conv)
        ->get();
        $escrito = true;
        foreach($requests as $aux){
            $aux->nombre_aux = $aux->nombre;
            if($escrito){
                $aux->nombre = 'escrito';
            } else {
                $aux->nombre = 'oral';
            }
            $escrito = !$escrito;
        }
        return $requests;
    }
}
