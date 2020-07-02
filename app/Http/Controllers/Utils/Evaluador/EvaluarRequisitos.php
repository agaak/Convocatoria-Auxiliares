<?php

namespace App\Http\Controllers\Utils\Evaluador;

use App\Models\EvaluadorConocimientos;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_req_aux;

class EvaluarRequisitos
{   
    
    public function getAuxiliaturas($id_post){
        $requests = Postulante_auxiliatura::where('id_postulante','=',$id_post)
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->join('postulante_req_aux', 'postulante_auxiliatura.id', '=', 'postulante_req_aux.id')
        ->orderBy('postulante_auxiliatura.id', 'ASC')
        ->get();
        return $requests;
    }
    
    public function getMapVerification($auxiliaturas,$requisitos){
        $mapVerifications = array();
        foreach ($auxiliaturas as &$auxiliatura) {
            foreach ($requisitos as $requisito) {
              $value = Postulante_req_aux::where('id_postulante_auxiliatura','=', $auxiliatura->id)
                                    ->where('id_requisito','=', $requisito->id)->first();
              $mapVerifications[$auxiliatura->id][$requisito->id] = array(                    
                        'esValido' => $value->habilitado,
                        'observacion' => $value->observacion,);
            }
        }
        return $mapVerifications;
    }
}
