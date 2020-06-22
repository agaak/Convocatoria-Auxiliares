<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Postulante;
use App\PrePostulante;
use App\Auxiliatura;
use App\Postulante_auxiliatura;
use App\Postulante_conovocatoria;
use App\PostuCalifConoc;
use App\PostuCalifConocFinal;
use App\PostuCalifMerito;
use App\PostuCalifMeritoFinal;
use App\Requerimiento;
use App\Merito;

class AdmPostulantesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {
        $id_conv = session()->get('convocatoria');
        
        $listaRotulos = PrePostulante::where('id_convocatoria',$id_conv)->get();
       
        $listaAux = PrePostulante::select('pre_postulante.id','nombre_aux','auxiliatura.id as id_aux')
        ->where('id_convocatoria',$id_conv)
        ->join('pre_postulante_auxiliatura','pre_postulante.id','=','id_pre_postulante')
        ->join('auxiliatura','pre_postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->get();
        $listaAux = collect($listaAux)->groupBy('id');
        $listPostulantes = Postulante_auxiliatura::select('postulante_auxiliatura.*',
        'postulante.*','auxiliatura.nombre_aux')
        ->join('postulante','postulante_auxiliatura.id_postulante','=','postulante.id')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->where('id_convocatoria',$id_conv)
        /* ->groupBy('postulante_auxiliatura.id','postulante.id') */->get();

        return view('admConvocatoria.admPostulantes',compact('listPostulantes','listaAux','listaRotulos'));
    }


    public function create(Request $request){
        $postulante = new Postulante();
        $postulante->nombre = request()->input('postulante-nombre');
        $postulante->apellido = request()->input('postulante-apellidos');
        $postulante->direccion = request()->input('postulante-direccion');
        $postulante->correo = request()->input('correo-direccion');
        $postulante->cod_sis = request()->input('cod-sis');
        $postulante->telefono = request()->input('telefono');
        $postulante->ci = request()->input('ci');
        $postulante->save();
        $postulante_con = new Postulante_conovocatoria();
        $postulante_con->id_postulante =  $postulante->id;
        $postulante_con->id_convocatoria = request()->input('id-conv-postulante');
        $postulante_con->save();

        $arreglo = request()->input('auxiliaturas'); 
        foreach ($arreglo as $aux) {
            $postulante_aux = new Postulante_auxiliatura();
            $postulante_aux->id_postulante = $postulante->id;
            $postulante_aux->id_auxiliatura = $aux;
            $postulante_aux->observacion = "ninguna";
            $postulante_aux->save();
            $post_calf_conoc_fin = new PostuCalifConocFinal();
            $post_calf_conoc_fin->id_convocatoria = session()->get('convocatoria');
            $post_calf_conoc_fin->id_postulante = $postulante->id; 
            $post_calf_conoc_fin->id_auxiliatura = $aux;
            $post_calf_conoc_fin->save();

            $porcentajes = Requerimiento::select('porcentaje.*')
            ->where('requerimiento.id_convocatoria',session()->get('convocatoria'))
            ->join('porcentaje','porcentaje.id_requerimiento','=','requerimiento.id')
            ->where('porcentaje.id_auxiliatura', $aux)
            ->where('porcentaje.porcentaje','>','0')
            ->get();
            
            foreach($porcentajes as $por){
                $post_calf_conoc = new PostuCalifConoc();
                $post_calf_conoc->id_postulante = $postulante->id;
                $post_calf_conoc->id_porcentaje = $por->id;
                $post_calf_conoc->id_calf_final = $post_calf_conoc_fin->id;
                $post_calf_conoc->save();
            }
           
        }

        $post_calf_merit_fin = new PostuCalifMeritoFinal();
        $post_calf_merit_fin->id_convocatoria = session()->get('convocatoria');
        $post_calf_merit_fin->id_postulante = $postulante->id; 
        $post_calf_merit_fin->save();


        $meritos = Merito::where('id_convocatoria',session()->get('convocatoria'))->get();
        
        foreach($meritos as $merit){
            $meritoExist = Merito::where('id_convocatoria',session()->get('convocatoria'))
            ->where('id_submerito',$merit->id)
            ->get();
            if($meritoExist->isEmpty()){
                $post_calf_merit = new PostuCalifMerito();
                $post_calf_merit->id_postulante = $postulante->id;
                $post_calf_merit->id_merito = $merit->id; 
                $post_calf_merit->id_calf_final = $post_calf_merit_fin->id;
                $post_calf_merit->save();
            }
        }
        
        return back();
    }
}
