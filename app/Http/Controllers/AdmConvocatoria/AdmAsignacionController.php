<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;
use App\Models\Convocatoria;

class AdmAsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:secretaria']);
    }
    
    public function index()
    {   
        $id_conv = session()->get('convocatoria');
        
        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();
        $tipoConv= Convocatoria::select('tipo_convocatoria.id')
                    ->join('tipo_convocatoria', 'tipo_convocatoria.id', '=', 'convocatoria.id_tipo_convocatoria')
                    ->where('convocatoria.id',$id_conv)
                    ->get();
                    
        if($tipoConv[0]->id == 1){
            $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
            'calf_final_postulante_merito.nota_final_merito','calf_fin_postulante_conoc.nota_final_conoc','postulante_auxiliatura.id_auxiliatura')
            ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
            ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
            ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
            ->where('postulante_auxiliatura.habilitado', true)
            ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
            ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
            ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
            ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
            ->where('calf_fin_postulante_conoc.nota_final_conoc','!=',null)
            ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','nota_final_merito','nota_final_conoc')
            ->get();
            $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        
        }else if($tipoConv[0]->id == 2){
            /*$listaNull = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
                    'calf_final_postulante_merito.nota_final_merito','calf_fin_postulante_conoc.nota_final_conoc','postulante_auxiliatura.id_auxiliatura')
                    ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
                    ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
                    ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
                    ->where('postulante_auxiliatura.habilitado', true)
                    ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
                    ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
                    ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
                    ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
                    ->join('calif_conoc_post', 'calif_conoc_post.id_calf_final','=','calf_fin_postulante_conoc.id')
                    ->where('calif_conoc_post.calificacion','=',null)
                    ->join('auxiliatura','auxiliatura.id','=','postulante_auxiliatura.id_auxiliatura')
                    ->get();
            $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
                    'calf_final_postulante_merito.nota_final_merito','calf_fin_postulante_conoc.nota_final_conoc','postulante_auxiliatura.id_auxiliatura')
                    ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
                    ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
                    ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
                    ->where('postulante_auxiliatura.habilitado', true)
                    ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
                    ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
                    ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
                    ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
                    ->where('calf_fin_postulante_conoc.nota_final_conoc','!=',null)
                    ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','nota_final_merito','nota_final_conoc')
                    ->get();*/
            return "pizarra";
        }else{

        }
        
        return $listaPost;
        //return view('admConvocatoria.admAsignacionItems',compact('listaAux','listaPost'));
    }

}
