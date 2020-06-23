<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\ConvocatoriaComp;

class CalificarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index(){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        foreach ($convs as $conv) {
            if ($conv->id == session()->get('convocatoria'))
                $pivot = $conv->pivot;
        }
        
        session()->put('evaluador', $pivot['id_evaluador']);
        $idEC = EvaluadorConovocatoria::where('id_convocatoria', $pivot['id_convocatoria'])->
                                        where('id_evaluador', $pivot['id_evaluador'])->value('id');
        $rolsEval = new EvaluadorComp();
        $roles = $rolsEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');

        $auxsTemsEval = $tipoConv === 1? $rolsEval->getTemsEvaluador($idEC) :$rolsEval->getAuxsEvaluador($idEC);
        
        return view('evaluador.calificar', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval'));
    }
}
