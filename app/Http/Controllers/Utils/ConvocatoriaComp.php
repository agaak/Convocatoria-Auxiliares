<?php

namespace App\Http\Controllers\Utils;

use App\Convocatoria;
use App\EvaluadorConocimientos;

class ConvocatoriaComp
{   
    public function getConvocatorias(){
        $requests= Convocatoria::where('id_unidad_academica',1)
        ->orderBy('id','ASC')->get();
        return $requests;
    }

    public function getConvocatoriasPublicas(){
        $requests= Convocatoria::where('id_unidad_academica',1)
        ->where('publicado',true)
        ->get();
        return $requests;
    }

    public function getEvaluadoresConvo($id){
        $requests = EvaluadorConocimientos::select('evaluador.*','convocatoria.titulo','evaluador_conovocatoria.id  as id_eva_con')
        ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
        ->where('evaluador_conovocatoria.id_convocatoria',$id)
        ->join('convocatoria','evaluador_conovocatoria.id_convocatoria','=','convocatoria.id')
        ->groupBy('evaluador.id','convocatoria.titulo','evaluador_conovocatoria.id')
        ->get();
        return $requests;
    }

    function uniqidReal($lenght = 8) {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
    
}
