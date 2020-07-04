<?php

namespace App\Http\Controllers\Utils\Evaluador;

use App\Models\Postulante;
use App\Models\PostuCalifConocFinal;
use App\Models\PostuCalifConoc;
use App\Models\Tematica;
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
        $requests = PostuCalifConocFinal::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 
            'postulante.id', 'calif_conoc_post.calificacion','calif_conoc_post.id as id_nota')
            ->where('calf_fin_postulante_conoc.id_convocatoria', session()->get('convocatoria'))
            ->join('calif_conoc_post','calif_conoc_post.id_calf_final','=', 'calf_fin_postulante_conoc.id')
            ->join('porcentaje','porcentaje.id','=','calif_conoc_post.id_porcentaje')
            ->where('porcentaje.id_tematica',$id_tem)
            ->join('postulante','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
            
            ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
            ->where('postulante_auxiliatura.habilitado',true)

            ->orderBy('postulante.apellido','ASC')
            //->groupBy('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calif_conoc_post.calificacion','calif_conoc_post.id as id_nota')
            ->get();
        $requests = collect($requests)->groupBy('id');
        return $requests;    
    }

    public function  getPostulantesByAux($id_aux,$nom_tem){
        $nom_tem_db = strcmp($nom_tem,'escrito') == 0? 'Examen escrito' : 'Examen oral';
        $id_tem = Tematica::where('nombre',$nom_tem_db)->value('id');
        $requests = PostuCalifConocFinal::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calif_conoc_post.calificacion','calif_conoc_post.id as id_nota')
            ->where('calf_fin_postulante_conoc.id_convocatoria', session()->get('convocatoria'))
            ->join('calif_conoc_post','calif_conoc_post.id_calf_final','=', 'calf_fin_postulante_conoc.id')
            ->join('porcentaje','porcentaje.id','=','calif_conoc_post.id_porcentaje')
            ->where('porcentaje.id_auxiliatura',$id_aux)
            ->where('porcentaje.id_tematica',$id_tem)
            ->join('postulante','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
            
            ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
            ->where('postulante_auxiliatura.habilitado',true)

            ->groupBy('postulante.id', 'calif_conoc_post.id')
            ->orderBy('postulante.apellido','ASC')
            ->get();

            // $requests = collect($requests)->groupBy('id');
        return $requests;    
    }
    
    public function  getPublicado($postulantes){
        $publicado = false;
        foreach($postulantes as $postulante){
            foreach($postulante as $nota){
                $publicado = $publicado || PostuCalifConoc::where('id', $nota->id_nota)->where('estado','publicado')->get()->isNotEmpty();
                
            }
            if($publicado){ break; }
        }
        return $publicado;    
    }

    public function  getEntregado($postulantes){
        $entregado = false;
        foreach($postulantes as $postulante){
            foreach($postulante as $nota){
                $entregado = $entregado || PostuCalifConoc::where('id', $nota->id_nota)->where('estado','entregado')->get()->isNotEmpty();
                
            }
            if($entregado){ break; }
        }
        return $entregado;    
    }

}
