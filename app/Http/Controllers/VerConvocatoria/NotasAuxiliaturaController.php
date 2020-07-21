<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Postulante;
use App\Models\Auxiliatura;
use App\Models\Convocatoria;
use App\Models\Porcentaje;
use App\Models\PostuCalifConoc;
use App\Models\PostuCalifConocFinal;
use App\Models\Postulante_auxiliatura;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;

class NotasAuxiliaturaController extends Controller
{
    public function index() {
        $id_conv = session()->get('convocatoria');
        $listaAux = (new ConocimientosComp)->getRequerimientos($id_conv);
        $tematicas = (new ConocimientosComp)->getTems($id_conv);
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id', 'calf_fin_postulante_conoc.id_auxiliatura')
            ->join('calf_fin_postulante_conoc','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
            ->where('calf_fin_postulante_conoc.nota_final_conoc','!=',null)
            ->where('calf_fin_postulante_conoc.id_convocatoria',$id_conv)
            ->groupBy('postulante.nombre','postulante.apellido','postulante.ci','postulante.id', 'calf_fin_postulante_conoc.id_auxiliatura',
                    'nota_final_conoc')->get();
        // return $tematicas;
        // foreach($listaAux as $aux){
        //     $tems = Porcentaje::select('id_tematica','tematica.nombre','porcentaje.id as id_por','porcentaje','id_area','area_calificacion.nombre as area')
        //         ->join('requerimiento','requerimiento.id','=','porcentaje.id_requerimiento')
        //         ->where('requerimiento.id_convocatoria',$id_conv)
        //         ->where('porcentaje.id_auxiliatura',$aux->id)
        //         ->join('tematica','tematica.id','=','porcentaje.id_tematica')
        //         ->join('area_calificacion','area_calificacion.id','=','porcentaje.id_area')
        //         ->orderBy('id_por','ASC')->get();
        //     $publicado = true;
        //     foreach($tems as $tem){
        //         if(!$publicado) break;
        //         $postulantes = (new PostulanteComp)->getPostulantesByTemFin($tem['id_tematica'],$tem->id_area);
        //         foreach($postulantes as $post){
        //             $calf_final = PostuCalifConocFinal::select('nota_final_conoc', 'id')
        //                 ->where('nota_final_conoc','!=',null)->where('id_convocatoria',$id_conv)
        //                 ->where('id_postulante',$post->id)->where('id_auxiliatura',$aux->id)->first();
        //             if($calf_final == null){
        //                 $postulantes = [];
        //                 break;
        //             } 
        //             $post->nota_final_conoc = $calf_final->nota_final_conoc;
        //             $calf_tems = PostuCalifConoc::select('calificacion','porcentaje','estado')
        //                 ->where('id_postulante',$post->id)->where('id_calf_final',$calf_final->id)
        //                 ->join('porcentaje','porcentaje.id','=','id_porcentaje')->orderBy('id_porcentaje','ASC')->get();
        //             foreach($calf_tems as $calf){
        //                 if($calf->calificacion != null){
        //                     $calf->calificacion = number_format($calf->calificacion*$calf->porcentaje/100 ,2);
        //                 }
        //                 if(strcmp($calf->estado,"publicado") != 0){
        //                     $calf->calificacion = null;
        //                     $publicado = false;
        //                     break;
        //                 }
        //             }
        //             $post->notas_tems = $calf_tems;
        //         }
        //         $tem->postulantes = $postulantes;     
        //     }
        //     $aux->tematicas = $publicado? $tems->groupBy('id_tematica') : [];
        // }
        // return $listaAux;
        foreach($listaPost as $postulante){ 
            $calf_final = PostuCalifConocFinal::select('nota_final_conoc', 'id')
                ->where('nota_final_conoc','!=',null)->where('id_convocatoria',$id_conv)
                ->where('id_postulante',$postulante->id)->where('id_auxiliatura',$postulante->id_auxiliatura)->first();
            if($calf_final == null){
                continue;
            } 
            $postulante->nota_final_conoc = $calf_final->nota_final_conoc;
            $calf_tems = PostuCalifConoc::select('calificacion','porcentaje','estado','id_area','id_tematica')
                ->where('id_postulante',$postulante->id)->where('id_calf_final',$calf_final->id)
                ->join('porcentaje','porcentaje.id','=','id_porcentaje')->orderBy('id_porcentaje','ASC')->get();
            foreach($calf_tems as $calf){
                if($calf->calificacion != null){
                    $calf->calificacion = number_format($calf->calificacion*$calf->porcentaje/100 ,2);
                }
                if(strcmp($calf->estado,"publicado") != 0){
                    $calf->calificacion = null;
                    // $calf_tems = []; 
                }
            }
            $postulante->notas_tems = $calf_tems->groupBy('id_tematica');
        }
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');

        $conv = Convocatoria::find($id_conv);
        // return $listaAux;
        return view('verConvocatoria.notasConocimientoA',compact('listaAux','tematicas','listaPost','conv'));
    }
}
