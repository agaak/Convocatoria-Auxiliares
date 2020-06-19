<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use Illuminate\Http\Request;
use App\Postulante;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\ConvocatoriaComp;

class CalificarConocController extends Controller
{
    public function index($id_tem){
        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        
        $compEval = new EvaluadorComp();
        $idEC = $compEval->getIdEvaConv();
        $roles = $compEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        $auxsTemsEval = $tipoConv === 1? $compEval->getTemsEvaluador($idEC) :$compEval->getAuxsEvaluador($idEC);

        $compEval = new PostulanteComp();
        $postulantes= $compEval->getPostulantesByTem($id_tem);

        return $auxsTemsEval;//view('evaluador.calificarConocimiento', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulantes'));
    }
}