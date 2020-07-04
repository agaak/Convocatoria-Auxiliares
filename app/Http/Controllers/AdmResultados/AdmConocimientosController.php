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
use App\Models\Calificacion_final;
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
        $tipoConv = Convocatoria::where('id', $id_conv)->value('id_tipo_convocatoria');
        $tematicas = (new ConocimientosComp)->getItems($id_conv);
        $tematicas= $tipoConv === 1? $tematicas : (new RequerimientoComp)->getRequerimientos2($id_conv);
        // return $tematicas;
        $compPost = new PostulanteComp();
        foreach($tematicas as $tem){
            
            $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($tem->id) : 
                                           $compPost->getPostulantesByAux($tem->id_aux,$tem->nombre);
            $postulantes= $tipoConv === 1? $postulantes :collect($postulantes)->groupBy('id'); 

            $entregado = $compPost->getEntregado($postulantes);
            $publicado = $compPost->getPublicado($postulantes);

            if(!$publicado){
                if(!$entregado){
                    $postulantes = [];
                }
            }                             
            $tem->postulantes = $postulantes;
            $tem->publicado = $publicado;
            $tem->entregado = $entregado;
        }
        // return $tematicas;
        return view('admResultados.admResConocimientos',compact('tematicas','tipoConv'));
    }

    public function publicar($id_tem,$nom){
        
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        
        $compPost = new PostulanteComp();
        $postulantes= $tipoConv === 1? $compPost->getPostulantesByTem($id_tem) : $compPost->getPostulantesByAux($id_tem,$nom); 
        $postulantes= $tipoConv === 1? $postulantes :collect($postulantes)->groupBy('id'); 
        foreach($postulantes as $postulante){
            $postulante = collect($postulante)->groupBy('id_nota');
            // return $postulante->pop()[0]->id;
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
                    
                }
            }
            $id_post = $postulante->pop()[0]->id;
            $auxs = Postulante_auxiliatura::where('id_postulante', $id_post)->get();
            foreach($auxs as $aux){
                $nota_fin_conoc = PostuCalifConocFinal::where('id_postulante', $id_post)
                        ->where('id_auxiliatura',$aux->id_auxiliatura)->value('nota_final_conoc');

                $porcentaje = Calificacion_final::where('id_convocatoria', session()->get('convocatoria'))->value('porcentaje_conocimiento');        
                $porciento =  number_format($nota_fin_conoc*$porcentaje/100 ,2);
                $nota_fin = Postulante_auxiliatura::where('id_postulante', $id_post)->value('calificacion');
                $nota_fin += $porciento;
                // Postulante_auxiliatura::where('id_postulante', $id_post)->update([
                //     'calificacion' => $nota_fin,
                // ]); 
            }
        }

        return back();
    }

        
        
}
