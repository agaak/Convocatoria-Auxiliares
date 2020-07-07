<?php

namespace App\Http\Controllers\Utils\Evaluador;

use App\Models\EvaluadorConocimientos;
use App\Models\Tipo_evaluador;
use App\Models\Convocatoria;

class MenuDina
{   
    
    public function getConvs(){
        $requests = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        $requests = collect($requests)->reject(function ($value) {
            return !$value->publicado || $value->finalizado;
        });
        return $requests;
    }
    
}
