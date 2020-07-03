<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\PostuCalifConoc;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;

class AdmConocimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {   
        $id_conv = session()->get('convocatoria');
        $tipoConv = Convocatoria::where('id', $id_conv)->value('id_tipo_convocatoria');
        $tematicas = (new ConocimientosComp)->getItems($id_conv);
        $compPost = new PostulanteComp();
        foreach($tematicas as $tem){
            $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($tem->id) : 
                                           $compPost->getPostulantesByAux($tem->id,$tem->nombre); 
            $tem->postulantes = $postulantes;
            $tem->entregado = $compPost->getEntregado($postulantes);
            $tem->publicado = $compPost->getPublicado($postulantes);
        }

        return view('admResultados.admResConocimientos',compact('tematicas','tipoConv'));
    }

    public function publicar($id_tem,$nom){
        
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        
        $compPost = new PostulanteComp();
        $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($id_tem) : $compPost->getPostulantesByAux($id_tem,$nom); 

        foreach($postulantes as $postulante){
            foreach($postulante as $nota){
                PostuCalifConoc::where('id', $nota->id_nota)->update([
                    'estado' => 'publicado',
                ]);
            }
        }

        return back();
    }
}
