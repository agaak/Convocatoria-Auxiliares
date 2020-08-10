<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\PostuCalifConoc;
use App\Models\PostuCalifConocFinal;
use App\Models\Postulante_auxiliatura;
use App\Models\Porcentaje;
use App\Models\Tematica;
use App\Models\Calificacion_final;
use App\Models\PostuCalifMeritoFinal;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;
use App\Http\Controllers\Utils\Convocatoria\RequerimientoComp;

class AdmConocimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {   
        $id_conv = session()->get('convocatoria');
        $conv = Convocatoria::find($id_conv);
        $tipoConv = $conv->id_tipo_convocatoria;
        $tematicas = (new ConocimientosComp)->getTemConv2($id_conv);
        foreach($tematicas as $tem){
            foreach($tem['areas'] as $area){
                $postulantes= (new PostulanteComp)->getPostulantesByTem($tem['id'],$area->id_area);

                $entregado = (new PostulanteComp)->getEntregado($postulantes);
                $publicado = (new PostulanteComp)->getPublicado($postulantes); 

                if(!$publicado){
                    if(!$entregado){
                        $postulantes = [];
                    }
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
                $area->entregado = $entregado;
            }
        }
        // return $tematicas;
        return view('admResultados.admResConocimientos',compact('tematicas','tipoConv','conv'));
    }

    public function publicar($id_tem,$id_area){
        session()->put('id_tem',$id_tem);
        session()->put('id_area',$id_area);
        $postulantes= (new PostulanteComp)->getPostulantesByTem($id_tem,$id_area);
        foreach($postulantes as $postulante){
            $postulante = collect($postulante)->groupBy('id_nota');
            foreach($postulante as $nota){
                PostuCalifConoc::where('id', $nota[0]->id_nota)->update([
                    'estado' => 'publicado',
                ]);
                $id_not_conoc_fin = PostuCalifConoc::where('id', $nota[0]->id_nota)->value('id_calf_final');
                $calf_final_conoc = PostuCalifConocFinal::where('id', $id_not_conoc_fin)->value('nota_final_conoc');
                if($nota[0]->calificacion != null){
                    $calf_final_conoc = $calf_final_conoc === null? 0 : $calf_final_conoc; 
                    $id_porcentaje = PostuCalifConoc::where('id', $nota[0]->id_nota)->value('id_porcentaje');
                    $porcentaje = Porcentaje::where('id', $id_porcentaje)->value('porcentaje');

                    $porciento =  number_format($nota[0]->calificacion*$porcentaje/100 ,2);

                    $calf_final_conoc += $porciento;
                    PostuCalifConocFinal::where('id', $id_not_conoc_fin)->update([
                        'nota_final_conoc' => $calf_final_conoc,
                    ]); 
                    $porcentaje_conoc = Calificacion_final::where('id_convocatoria', session()->get('convocatoria'))->value('porcentaje_conocimiento');        
                    $porciento_conoc =  number_format($calf_final_conoc*$porcentaje_conoc/100 ,2);

                    $nota_fin_merito = PostuCalifMeritoFinal::where('id_postulante', $nota[0]->id)->value('nota_final_merito');
                    
                    $porcentaje_merit = Calificacion_final::where('id_convocatoria', session()->get('convocatoria'))->value('porcentaje_merito'); 
                    $porciento_merit =  number_format($nota_fin_merito*$porcentaje_merit/100 ,2);
                    $id_aux = PostuCalifConocFinal::where('id', $id_not_conoc_fin)->value('id_auxiliatura');
                    Postulante_auxiliatura::where('id_postulante', $nota[0]->id)
                            ->where('id_auxiliatura',$id_aux)->update([
                        'calificacion' => ($porciento_merit + $porciento_conoc),
                    ]); 
                }
            }
        }
        return back();
    }

        
        
}
