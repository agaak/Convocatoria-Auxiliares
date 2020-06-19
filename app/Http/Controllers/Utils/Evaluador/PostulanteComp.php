<?php

namespace App\Http\Controllers\Utils\Evaluador;

use App\Postulante;

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
        $requests = Postulante:://select('postulante.*', 'calf_fin_postulante_conoc.nota_final_conoc as nota')
            join('postulante_convocatoria','postulante_convocatoria.id_postulante','=', 'postulante.id')
            ->where('postulante_convocatoria.id_convocatoria', session()->get('convocatoria'))
            ->join('postulante_auxiliatura','postulante_auxiliatura.id_postulante','=','postulante.id')
            ->join('requerimiento','requerimiento.id_auxiliatura','=','postulante_auxiliatura.id_auxiliatura')
            ->join('porcentaje','porcentaje.id_requerimiento','=','postulante_auxiliatura.id_auxiliatura')
            ->where('porcentaje.id_tematica',$id_tem)
            //->where('porcentaje.porcentaje','>',0)
            //->join('calif_conoc_post', 'calif_conoc_post.id_postulante', '=', 'postulante.id')
            
            ->get();
        return $requests;    
    }
    
}
