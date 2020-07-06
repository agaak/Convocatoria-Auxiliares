<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\Tematica;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use App\Models\Postulante_auxiliatura;

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
        /*if($tipoConv[0]->id == 1){
            $listaPost =  Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
            'postulante_auxiliatura.calificacion','postulante_auxiliatura.item','postulante_auxiliatura.id_auxiliatura')
            ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
            ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
            ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
            ->where('postulante_auxiliatura.habilitado', true)
            ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
            ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
            ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
            ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
            ->whereNotNull('postulante_auxiliatura.calificacion')
            ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','postulante_auxiliatura.calificacion','postulante_auxiliatura.item')
            ->orderBy('postulante_auxiliatura.calificacion', 'DESC')
            ->get();
            $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        
        }else if($tipoConv[0]->id == 2){*/
            
            $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
            'postulante_auxiliatura.calificacion','postulante_auxiliatura.item','postulante_auxiliatura.id_auxiliatura')
            ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
            ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
            ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
            ->where('postulante_auxiliatura.habilitado', true)
            ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
            ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
            ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
            ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
            ->whereNotNull('postulante_auxiliatura.calificacion')
            ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','postulante_auxiliatura.calificacion','postulante_auxiliatura.item')
            ->orderBy('postulante_auxiliatura.calificacion', 'DESC')
            ->get();
            $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
            return $listaPost;
         /*   
        //}else{
            
        }*/
        return view('admConvocatoria.admAsignacionItems',compact('listaAux','listaPost'));
    }

    
}
