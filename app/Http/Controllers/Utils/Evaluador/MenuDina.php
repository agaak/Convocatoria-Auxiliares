<?php

namespace App\Http\Controllers\Utils\Evaluador;

use App\EvaluadorConocimientos;
use App\Tipo_evaluador;
use App\Convocatoria;

class MenuDina
{   
    
    public function getConvs(){
        $requests = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        return $requests;
    }
    
}
