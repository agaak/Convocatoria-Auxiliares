<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\Convocatoria;
use App\Models\EvaluadorConocimientos;
use App\Models\EvaluadorConovocatoria;
use App\Models\PostuCalifConoc;
use App\Models\Postulante_auxiliatura;
use Illuminate\Http\Request;
use App\Models\Postulante;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\ConvocatoriaComp;
use App\Models\Postulante_conovocatoria;

class CalificarRequisitoController extends Controller
{
    public function index(){
        if(session()->has('id-pos')){
            Postulante_conovocatoria::where('id_postulante', session()->get('id-pos'))->update([
                'calificando_requisito' => false,
            ]);
            session()->forget('id-pos');
        }
        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        
        $compEval = new EvaluadorComp();
        $idEC = $compEval->getIdEvaConv();
        $roles = $compEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        $auxsTemsEval = $tipoConv === 1? $compEval->getTemsEvaluador($idEC) :$compEval->getAuxsEvaluador($idEC);

        $listPostulanteAux = Postulante_auxiliatura::select('postulante_auxiliatura.observacion', 'postulante_auxiliatura.id_postulante',
        'postulante_auxiliatura.habilitado','auxiliatura.nombre_aux')
        ->where('id_convocatoria',session()->get('convocatoria'))
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->get();
        $listPostulanteAux = collect($listPostulanteAux)->groupBy('id_postulante');

        $listPostulantes = Postulante::select('postulante.*')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('id_convocatoria',session()->get('convocatoria'))
        ->orderBy('apellido','ASC')->get();

        foreach($listPostulantes as $item){
            $item->nombre_aux = $listPostulanteAux[$item['id']];
        }
        $entregado = Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','entregado')->get()->isNotEmpty();
        $publicado = Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','publicado')->get()->isNotEmpty();
        return view('evaluador.calificarRequisitosPost', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','listPostulantes','entregado','publicado'));
    }

    public function entregar(Request $request){
        $listPostulantes = Postulante_auxiliatura::where('id_convocatoria',session()->get('convocatoria'))
        ->where('postulante_auxiliatura.habilitado',null)->get();
        if($listPostulantes->isNotEmpty()){
            request()->validate([
                'id-evaluador' => 'required'
            ],[
                'id-evaluador' => 'No se puede entregar. Hay Postulantes sin calificar.'
            ]);
        }
        Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))->update([
            'estado' => 'entregado',
        ]);
        return back();
    }
}