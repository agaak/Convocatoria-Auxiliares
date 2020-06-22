<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\PostuCalifConoc;
use App\Postulante_auxiliatura;
use Illuminate\Http\Request;
use App\Postulante;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\ConvocatoriaComp;

class CalificarRequisitoController extends Controller
{
public function index(){
        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        
        $compEval = new EvaluadorComp();
        $idEC = $compEval->getIdEvaConv();
        $roles = $compEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        $auxsTemsEval = $tipoConv === 1? $compEval->getTemsEvaluador($idEC) :$compEval->getAuxsEvaluador($idEC);

        $listPostulanteAux = Postulante_auxiliatura::select('postulante_auxiliatura.observacion', 'postulante_auxiliatura.id_postulante',
        'postulante_auxiliatura.habilitado','auxiliatura.nombre_aux')
        ->join('postulante_conovocatoria','postulante_conovocatoria.id_postulante','=','postulante_auxiliatura.id_postulante')
        ->where('id_convocatoria',session()->get('convocatoria'))
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->get();
        $listPostulanteAux = collect($listPostulanteAux)->groupBy('id_postulante');

        $listPostulantes = Postulante::select('postulante.*')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('id_convocatoria',session()->get('convocatoria'))->get();

        foreach($listPostulantes as $item){
            $item->nombre_aux = $listPostulanteAux[$item['id']];
        }

        return view('evaluador.calificarRequisitosPost', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','listPostulantes'));
    }
}