<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use App\Models\PostuCalifConoc;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;
use App\Http\Controllers\Utils\Convocatoria\RequerimientoComp;

class NotasTematicaController extends Controller
{
    public function index() {
        $id_conv = session()->get('convocatoria');

        $conv = Convocatoria::find($id_conv);

        $tipoConv = $conv->id_tipo_convocatoria;

        $tematicas = (new ConocimientosComp)->getItems($id_conv);
        $tematicas= $tipoConv === 1? $tematicas : (new RequerimientoComp)->getRequerimientos2($id_conv);

        $compPost = new PostulanteComp();
        foreach($tematicas as $tem){
            
            $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($tem->id) : 
                                           $compPost->getPostulantesByAux($tem->id_aux,$tem->nombre);
            $postulantes= $tipoConv === 1? $postulantes :collect($postulantes)->groupBy('id'); 

            $publicado = $compPost->getPublicado($postulantes);

            if(!$publicado){
                $postulantes = [];
            }                             
            $tem->postulantes = $postulantes;
            $tem->publicado = $publicado;
        }
        
        return view('verConvocatoria.notasConocimientoT',compact('tematicas','tipoConv','conv'));
    }
}
