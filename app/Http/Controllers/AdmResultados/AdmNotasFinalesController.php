<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Requerimiento;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\Calificacion_final;
use App\Models\Postulante_auxiliatura;
use App\Models\PostuCalifConocFinal;
use App\Models\Postulante_conovocatoria;

class AdmNotasFinalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {   
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
                'calf_final_postulante_merito.nota_final_merito as nota_fin_merit')
        ->join('calf_final_postulante_merito','postulante.id','=','calf_final_postulante_merito.id_postulante')
        ->where('calf_final_postulante_merito.id_convocatoria',$id_conv)
        ->get();
        foreach($listaPost as $post){
            $post->nota_fin_merit = number_format($post->nota_fin_merit*$porcentaje_merit/100 ,2);
            $notas = Postulante_auxiliatura::select('calificacion as nota_fin','id_auxiliatura')
                ->where('id_postulante',$post->id)->get();
            foreach($notas as $aux){
                $aux->nota_fin_conoc = PostuCalifConocFinal::where('id_postulante',$post->id)
                    ->where('id_auxiliatura',$aux->id_auxiliatura)->value('nota_final_conoc');
                $aux->nota_fin_conoc = number_format($aux->nota_fin_conoc*$porcentaje_conoc/100 ,2); 
            }
            $notas = collect($notas)->groupBy('id_auxiliatura');
            $post->aux_conoc = $notas;
        }
        $conv = Convocatoria::find(session()->get('convocatoria'));
        return view('admResultados.admResNotasFinales',compact('listaAux','listaPost','titulo_conv',
                'porcentaje_conoc','porcentaje_merit','conv'));
    }

}
