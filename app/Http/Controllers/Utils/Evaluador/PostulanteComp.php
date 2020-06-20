<?php

namespace App\Http\Controllers\Utils\Evaluador;

use App\Postulante;
use App\PostuCalifConocFinal;

class PostulanteComp
{   
    
    public function getPostulantes(){
        $requests = Postulante::select('postulante.*', 'calf_fin_postulante_conoc.nota_final_conoc as nota')
            ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
            ->where('calf_fin_postulante_conoc.id_convocatoria', session()->get('convocatoria'))
            ->get();
        return $requests;
    }

    public function  getPostulantesByTem($id_tem){
        $requests = PostuCalifConocFinal::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calif_conoc_post.calificacion','calif_conoc_post.id as id_nota')
            ->where('calf_fin_postulante_conoc.id_convocatoria', session()->get('convocatoria'))
            ->join('calif_conoc_post','calif_conoc_post.id_calf_final','=', 'calf_fin_postulante_conoc.id')
            ->join('porcentaje','porcentaje.id','=','calif_conoc_post.id_porcentaje')
            ->where('porcentaje.id_tematica',$id_tem)
            ->join('postulante','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
            ->orderBy('postulante.apellido','ASC')
            ->get();
        $requests = collect($requests)->groupBy('id');
        return $requests;    
    }
    
}
