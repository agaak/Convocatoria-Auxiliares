<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Requerimiento;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\Calificacion_final;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_conovocatoria;
use App\Models\PostuCalifConocFinal;
use App\Models\PostuCalifConoc;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;

class NotasFinalesController extends Controller
{
    public function index() {
        $id_conv = session()->get('convocatoria');
        $porcentaje_conoc = Calificacion_final::where('id_convocatoria', $id_conv)->value('porcentaje_conocimiento'); 
        $porcentaje_merit = Calificacion_final::where('id_convocatoria', $id_conv)->value('porcentaje_merito'); 

        $tematicas = (new ConocimientosComp)->getTems($id_conv);
        // return $tematicas;
        $listaAux = (new ConocimientosComp)->getRequerimientos($id_conv);
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
                'calf_final_postulante_merito.nota_final_merito as nota_fin_merit')
            ->join('calf_final_postulante_merito','postulante.id','=','calf_final_postulante_merito.id_postulante')
            ->where('calf_final_postulante_merito.id_convocatoria',$id_conv)->where('estado','publicado')->get();
        foreach($listaPost as $post){
            $post->nota_fin_merit = number_format($post->nota_fin_merit*$porcentaje_merit/100 ,2);
            $notas = Postulante_auxiliatura::select('calificacion as nota_fin','id_auxiliatura')
                ->where('id_postulante',$post->id)->get();
            foreach($notas as $aux){
                $habilitado = Postulante_auxiliatura::where('id_postulante',$post->id)
                    ->where('id_auxiliatura',$aux->id_auxiliatura)->value('habilitado');
                $aux->habilitado = $habilitado;
                $id_nota_fin_conoc = PostuCalifConocFinal::where('id_postulante',$post->id)
                ->where('id_auxiliatura',$aux->id_auxiliatura)->value('id');
                $test = PostuCalifConoc::where('id_calf_final',$id_nota_fin_conoc)
                    ->where('estado','entregado')->get()->isEmpty();
                $test2 = PostuCalifConoc::where('id_calf_final',$id_nota_fin_conoc)
                    ->where('estado','publicado')->count();
                $test3 = count($tematicas[$aux->id_auxiliatura][0]['areas']);
                $aux->control = $test && ($test2 >= $test3);
                $nota_fin_conoc = PostuCalifConocFinal::where('id',$id_nota_fin_conoc)
                    ->value('nota_final_conoc');
                if($nota_fin_conoc != null){
                    $nota_fin_conoc = number_format($nota_fin_conoc*$porcentaje_conoc/100 ,2); 
                } else {
                    $aux->habilitado = false;
                }
                $aux->nota_fin_conoc = $nota_fin_conoc;
            }
            $notas = collect($notas)->reject(function ($value) {
                return !$value->habilitado || !$value->control;
            });
            $notas = $notas->groupBy('id_auxiliatura');
            $post->aux_conoc = $notas;
        }
        $conv = Convocatoria::find(session()->get('convocatoria'));

        return view('verConvocatoria.notasFinales',compact('listaAux','listaPost',
                        'porcentaje_conoc','porcentaje_merit','conv'));
    }
}
