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
        $tematicas = (new ConocimientosComp)->getTemConv2($id_conv);
        foreach($tematicas as $tem){
            foreach($tem['areas'] as $area){
                $postulantes= (new PostulanteComp)->getPostulantesByTem($tem['id'],$area->id_area);
                $publicado = (new PostulanteComp)->getPublicado($postulantes);
                if(!$publicado){
                    $postulantes = [];
                }           
                $dependiente = false;
                if(count($postulantes)>0){
                    $dependiente = $postulantes->collapse()[0]->id_porc_dependiente != null;
                    if($dependiente){
                        $postulantes = (new PostulanteComp)->getDependencia($postulantes); 
                        $postulantes = $postulantes->collapse()->reject(function ($value) {
                            return !$value->habilitado && !$value->esperando_dep;
                        });
                        $postulantes = $postulantes->groupBy('id');
                    }
                }                      
                $area->postulantes = $postulantes;
                $area->publicado = $publicado;
            }
        }
        return view('verConvocatoria.notasConocimientoT',compact('tematicas','tipoConv','conv'));
    }
}
