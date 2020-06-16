<?php

namespace App\Http\Controllers\Utils\AdmConvocatoria;

use App\EvaluadorConocimientos;
use App\EvaluadorTematica;
use App\EvaluadorAuxiliatura;

class EvaluadorComp
{   
    
    public function getEvaluadoresConvo($id){
        $requests = EvaluadorConocimientos::select('evaluador.*','convocatoria.titulo','evaluador_conovocatoria.id  as id_eva_con')
        ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
        ->where('evaluador_conovocatoria.id_convocatoria',$id)
        ->join('convocatoria','evaluador_conovocatoria.id_convocatoria','=','convocatoria.id')
        ->groupBy('evaluador.id','convocatoria.titulo','evaluador_conovocatoria.id')
        ->get();
        return $requests;
    }

    public function getAuxsEvaluador($id_eva_conv){
        $requests = EvaluadorAuxiliatura::select('auxiliatura.nombre_aux as nombre') 
        ->join('evaluador_conovocatoria','evaluador_auxiliatura.id_evaluador_convocatoria','=','evaluador_conovocatoria.id') 
        ->where('evaluador_conovocatoria.id',$id_eva_conv)
        ->join('auxiliatura','evaluador_auxiliatura.id_auxiliatura','=','auxiliatura.id')->get();
        return $requests;
    }

    public function getTemsEvaluador($id_eva_conv){
        $requests = EvaluadorTematica::select('tematica.nombre') 
        ->join('evaluador_conovocatoria','evaluador_tematica.id_evaluador_convocatoria','=','evaluador_conovocatoria.id')
        ->where('evaluador_conovocatoria.id',$id_eva_con)
        ->join('tematica','evaluador_tematica.id_tematica','=','tematica.id')->get();
        return $requests;
    }

    public function getRolesEvaluador($id_eva_conv){
        $requests = Tipo_evaluador::select('tipo_rol_evaluador.id','tipo_rol_evaluador.nombre')
        ->where('id_evaluador_convocatoria',$id_eva_con)
        ->join('tipo_rol_evaluador','tipo_evaluador.id_rol_evaluador','=','tipo_rol_evaluador.id')
        ->get();
        return $requests;
    }
    
}
