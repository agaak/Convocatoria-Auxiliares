<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\Convocatoria;
use App\Models\Postulante;
use Illuminate\Http\Request;
use App\Models\EvaluadorConocimientos;
use App\Models\EvaluadorConovocatoria;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;

class CalificarMeritoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index() {
        if(session()->has('id-pos')){
            Postulante_conovocatoria::where('id_postulante', session()->get('id-pos'))->update([
                'calificando_merito' => false,
            ]);
            session()->forget('id-pos');
        }

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

        $postulantes= Postulante::select('postulante.*', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->get();

        return view('evaluador.calificarMerito', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulantes'));
    }
}
