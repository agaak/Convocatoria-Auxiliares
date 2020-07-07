<?php

namespace App\Http\Controllers\Utils;

use App\Models\Convocatoria;
use App\Models\EvaluadorConocimientos;

class ConvocatoriaComp
{   
    public function getConvocatorias(){
        // $currentDate = date("Y-m-d");
        if(auth()->check()){
            $id_unidad = auth()->user()->unidad_academica_id;
            if(auth()->user()->hasRoles(['administrador'])){              
                $requests= Convocatoria::where('id_unidad_academica',$id_unidad)
                    ->where('finalizado',false)
                    ->where('creado',true)->orderBy('id','ASC')->get();
            } else if(auth()->user()->hasRoles(['secretaria'])){
                $requests= Convocatoria::where('id_unidad_academica',$id_unidad)
                    ->where('finalizado',false)
                    ->orderBy('id','ASC')->get();
            } else if(auth()->user()->hasRoles(['evaluador'])){
                $requests = EvaluadorConocimientos::where('correo', auth()->user()->email)
                ->first()->convocatorias;
                $requests = collect($requests)->reject(function ($value) {
                    return !$value->publicado || $value->finalizado;
                });
            }
        } else {
            $requests= Convocatoria::where('publicado',true) 
                ->where('finalizado',false)
                ->orderBy('id','DEC')->get();
        }
        
        return $requests;
    }

    public function getConvocatoriasPublicas(){
        $currentDate = date("Y-m-d");
        $requests= Convocatoria::where('publicado',true)
        ->where('finalizado',false)
        ->orderBy('id','DEC')->get();
        return $requests;
    }

    public function getEvaluadoresConvo($id){
        $requests = EvaluadorConocimientos::select('evaluador.*','convocatoria.titulo','evaluador_conovocatoria.id  as id_eva_con')
        ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
        ->where('evaluador_conovocatoria.id_convocatoria',$id)
        ->join('convocatoria','evaluador_conovocatoria.id_convocatoria','=','convocatoria.id')
        ->groupBy('evaluador.id','convocatoria.titulo','evaluador_conovocatoria.id')
        ->where('finalizado',false)
        ->get();
        return $requests;
    }

    public function getConvocatoriasPasadas($idUnidadAcademica){
        // $currentDate = date("Y-m-d");
        $requests = Convocatoria::where('id_unidad_academica',$idUnidadAcademica)
        ->where('publicado',true)
        ->where('finalizado',true)
        ->orderBy('id','DEC')
        ->get();
        return $requests;
    }

    public function searchConvocatorias($idUnidadAcademica, $idTipoConv, $gestion){
        $requests = Convocatoria::where('id_unidad_academica','=',$idUnidadAcademica)
        ->where('publicado',true)
        ->where('finalizado',true);

        if(!is_null($idTipoConv)){
            $requests = $requests->where('id_tipo_convocatoria','=',$idTipoConv);
        }
        if(!is_null($gestion)){
            $requests = $requests->where('gestion','=',$gestion);
        }
        $requests = $requests->orderBy('id','DEC')->get();
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
