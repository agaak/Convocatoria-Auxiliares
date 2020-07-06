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

class NotasFinalesController extends Controller
{
    public function index() {
        $id_conv = session()->get('convocatoria');
        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];

        $porcentaje_conoc = Calificacion_final::where('id_convocatoria', session()->get('convocatoria'))->value('porcentaje_conocimiento'); 
        $porcentaje_merit = Calificacion_final::where('id_convocatoria', session()->get('convocatoria'))->value('porcentaje_merito'); 

        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
        'calf_fin_postulante_conoc.nota_final_conoc','calf_final_postulante_merito.nota_final_merito','postulante_auxiliatura.id_auxiliatura','postulante_auxiliatura.calificacion as not_fin')
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->join('calf_fin_postulante_conoc','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
        ->join('calf_final_postulante_merito','postulante.id','=','calf_final_postulante_merito.id_postulante')
        ->where('postulante_auxiliatura.habilitado', true)
        ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','calf_fin_postulante_conoc.nota_final_conoc','calf_final_postulante_merito.nota_final_merito','not_fin')
        ->get();

        foreach($listaPost as $post){
            $post->nota_final_conoc = number_format($post->nota_final_conoc*$porcentaje_conoc/100 ,2);
            $post->nota_final_merito = number_format($post->nota_final_merito*$porcentaje_merit/100 ,2);
        }
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        
        $conv = Convocatoria::find(session()->get('convocatoria'));

        return view('verConvocatoria.notasFinales',compact('listaAux','listaPost','titulo_conv',
                        'porcentaje_conoc','porcentaje_merit','conv'));
    }
}
