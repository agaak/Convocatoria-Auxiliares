<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\Convocatoria;
use App\Models\Postulante;
use Illuminate\Http\Request;
use App\Models\EvaluadorConocimientos;
use App\Models\EvaluadorConovocatoria;
use App\Models\PostuCalifMeritoFinal;
use App\Models\Postulante_conovocatoria;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;

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

        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        foreach ($convs as $conv) {
            if ($conv->id == session()->get('convocatoria'))
                $pivot = $conv->pivot;
        }
        $idEC = EvaluadorConovocatoria::where('id_convocatoria', $pivot['id_convocatoria'])->
                                        where('id_evaluador', $pivot['id_evaluador'])->value('id');
        $rolsEval = new EvaluadorComp();
        $roles = $rolsEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');

        $auxsTemsEval = $rolsEval->getTematicsEvaluador2($idEC);

        $postulantes= Postulante::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->where('postulante_auxiliatura.habilitado',true)
        ->orderBy('postulante.apellido','ASC')
        ->get() ;
        $postulantes = collect($postulantes)->unique('id'); 
        $entregado = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','entregado')->get()->isNotEmpty();
        $publicado = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','publicado')->get()->isNotEmpty();
        // return $auxsTemsEval;
        return view('evaluador.calificarMerito', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulantes','entregado','publicado'));
    }

    public function entregar(Request $request){
        // $listPostulantes = PostuCalifMeritoFinal::where('id_convocatoria',session()->get('convocatoria'))
        // ->where('nota_final_merito',null)->get();

        $listPostulantes= Postulante::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('nota_final_merito',null)
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->where('postulante_auxiliatura.habilitado',true)
        ->orderBy('postulante.apellido','ASC')
        ->get() ;

        if($listPostulantes->isNotEmpty()){
            request()->validate([
                'id-evaluador' => 'required'
            ],[
                'id-evaluador.required' => 'No se puede entregar. Hay Postulantes sin calificar.'
            ]);
        }
        PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))->update([
            'estado' => 'entregado',
        ]);
        return back();
    }
}
