<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\PostuCalifConoc;
use Illuminate\Http\Request;
use App\Postulante;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\ConvocatoriaComp;

class CalificarConocController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index($id_tem,$nom){
        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        
        $compEval = new EvaluadorComp();
        $idEC = $compEval->getIdEvaConv();
        $roles = $compEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        $auxsTemsEval = $tipoConv === 1? $compEval->getTemsEvaluador($idEC) :$compEval->getAuxsEvaluador($idEC);

        $compEval = new PostulanteComp();
        $postulantes= $tipoConv === 1? $compEval->getPostulantesByTem($id_tem) : $compEval->getPostulantesByAux($id_tem,$nom); 

        return view('evaluador.calificarConocimiento', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulantes','id_tem'));
    }

    public function store(Request $request){
        $cont = 0;
        $test = "no";
        if ($request->input('id-tipo') == 1) {
            foreach($request->input('nota') as $nota) {
                $id_post = $request->input('id-post')[$cont++];
                foreach ($request->input('id_nota') as $ids) {
                    $parseID = explode(',',$ids);
                    if(intval($parseID[1]) == $id_post){
                        PostuCalifConoc::where('id', intval($parseID[0]))->update([
                            'calificacion' => $nota
                        ]);
                    }  
                }
                
            }
        } else {
            foreach ($request->input('nota') as $nota) {
                $id_post = $request->input('id-post')[$cont++];
                PostuCalifConoc::where('id', $id_post)->update([
                    'calificacion' => $nota
                ]);
                $test = "yes";
            }
        }
        
        
        return back();
    }
}