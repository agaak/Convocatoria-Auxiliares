<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\Requerimiento;
use App\Porcentaje;
use App\Tematica;

class ConocimientosComp
{   
    public function getRequerimientos($id_conv){
        $requests =Requerimiento::select('auxiliatura.nombre_aux','auxiliatura.cod_aux','requerimiento.id')
            ->where('id_convocatoria',$id_conv)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')->orderBy('requerimiento.id','ASC')->get();    
        
        return $requests;
    }
    
    public function getPorcentajes($id_conv){
        $porcentajes = Porcentaje::select('id_requerimiento','porcentaje.porcentaje','porcentaje.id_auxiliatura','id_tematica','tematica.nombre')
        ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
        ->where('requerimiento.id_convocatoria',$id_conv)->orderBy('id_requerimiento','ASC')
        ->join('tematica','porcentaje.id_tematica','=','tematica.id')
        ->orderBy('tematica.nombre','ASC')->get();
        return $porcentajes;
    }
    
    public function getItems($id_conv){
        $tems = Tematica::select('tematica.nombre','tematica.id')
            ->join('porcentaje','tematica.id','=','porcentaje.id_tematica')
            ->join('requerimiento','porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->groupBy('tematica.nombre','tematica.id')->orderBy('nombre','ASC')->get();
        return $tems;
    }
    
        
}
