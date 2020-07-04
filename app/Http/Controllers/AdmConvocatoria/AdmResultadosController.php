<?php

namespace App\Http\Controllers\AdmConvocatoria;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Requerimiento;
use App\Models\Postulante;
use App\Models\Convocatoria;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_conovocatoria;

class AdmResultadosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:secretaria']);
    }
    public function index()
    {   
        $id_conv = session()->get('convocatoria');
        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];

        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id', 
        'postulante_auxiliatura.calificacion','calf_fin_postulante_conoc.nota_final_conoc','calf_final_postulante_merito.nota_final_merito','postulante_auxiliatura.id_auxiliatura')
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->join('calf_fin_postulante_conoc','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
        ->join('calf_final_postulante_merito','postulante.id','=','calf_final_postulante_merito.id_postulante')
        ->where('postulante_auxiliatura.habilitado', true)
        ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','calf_fin_postulante_conoc.nota_final_conoc','calf_final_postulante_merito.nota_final_merito','postulante_auxiliatura.calificacion')
        ->get();
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        //return $listaPost;
        return view('admConvocatoria.admResultados',compact('listaAux','listaPost','titulo_conv'));
    }
    
}
