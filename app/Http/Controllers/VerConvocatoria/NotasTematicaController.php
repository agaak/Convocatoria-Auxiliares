<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use App\Models\PostuCalifConoc;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;

class NotasTematicaController extends Controller
{
    public function index() {
        $id_conv = session()->get('convocatoria');
        $tipoConv = Convocatoria::where('id', $id_conv)->value('id_tipo_convocatoria');
        $tematicas = (new ConocimientosComp)->getItems($id_conv);
        $compPost = new PostulanteComp();
        foreach($tematicas as $tem){
            $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($tem->id) : 
                                           $compPost->getPostulantesByAux($tem->id,$tem->nombre); 
            $publicado = $compPost->getPublicado($postulantes);
            $tem->publicado = $publicado;
            if(!$publicado){
                $postulantes = [];
            }
            $tem->postulantes = $postulantes;
        }
        return view('verConvocatoria.notasConocimientoT',compact('tematicas','tipoConv'));
    }
}
