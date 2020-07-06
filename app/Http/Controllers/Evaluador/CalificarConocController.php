<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\Convocatoria;
use App\Models\EvaluadorConocimientos;
use App\Models\EvaluadorConovocatoria;
use App\Models\PostuCalifConoc;
use Illuminate\Http\Request;
use App\Models\Postulante;
use App\Models\Postulante_conovocatoria;
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

        $compPost = new PostulanteComp();
        $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($id_tem) : $compPost->getPostulantesByAux($id_tem,$nom); 
        
        $publicado_habilitados = Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','publicado')->get()->isNotEmpty();
        
        $entregado = $compPost->getEntregado($tipoConv === 1? $postulantes :collect($postulantes)->groupBy('id'));
        $publicado = $compPost->getPublicado($tipoConv === 1? $postulantes :collect($postulantes)->groupBy('id'));

        if(!$publicado_habilitados){
            $postulantes = [];
        }
        return view('evaluador.calificarConocimiento', compact('convs', 'roles', 'tipoConv', 
            'auxsTemsEval','postulantes','id_tem','nom','publicado','entregado','publicado_habilitados'));
    }

    public function store(Request $request){
        $cont = 0;
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
            }
        }
        return back();
    }

    public function entregar(Request $request,$id_tem,$nom){
        
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        
        $compPost = new PostulanteComp();
        $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($id_tem) : $compPost->getPostulantesByAux($id_tem,$nom); 

        $postulantes= $tipoConv === 1? $postulantes :collect($postulantes)->groupBy('id');

        foreach($postulantes as $postulante){
            foreach($postulante as $nota){
                PostuCalifConoc::where('id', $nota->id_nota)->update([
                    'estado' => 'entregado',
                ]);
            }
        }
        return back();
    }
}