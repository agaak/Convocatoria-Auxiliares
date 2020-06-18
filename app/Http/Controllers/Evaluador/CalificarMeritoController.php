<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use Illuminate\Http\Request;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;

class CalificarMeritoController extends Controller
{
    public function index() {
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        foreach ($convs as $conv) {
            if ($conv->id == session()->get('convocatoria'))
                $pivot = $conv->pivot;
        }
        $idEC = EvaluadorConovocatoria::where('id_convocatoria', $pivot['id_convocatoria'])->
                                        where('id_evaluador', $pivot['id_evaluador'])->value('id');
        $rolsEval = new EvaluadorComp();
        $roles = $rolsEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');

        $auxsTemsEval = $tipoConv === 1? $rolsEval->getTemsEvaluador($idEC) :$rolsEval->getAuxsEvaluador($idEC);
        return view('evaluador.calificarMerito', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval'));
    }
}
