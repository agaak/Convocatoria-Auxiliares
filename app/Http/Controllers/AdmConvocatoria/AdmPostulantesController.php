<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Models\Postulante;
use App\Models\PrePostulante;
use App\Models\Auxiliatura;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_conovocatoria;
use App\Models\Postulante_req_aux;
use App\Models\PostuCalifConoc;
use App\Models\PostuCalifConocFinal;
use App\Models\PostuCalifMerito;
use App\Models\PostuCalifMeritoFinal;
use App\Models\Requerimiento;
use App\Models\Merito;

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
       
        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();

        $listaAux = collect($listaAux)->groupBy('id');
        $listPostulantes = Postulante_auxiliatura::select('postulante_auxiliatura.*',
        'postulante.*','auxiliatura.nombre_aux')
        ->join('postulante','postulante_auxiliatura.id_postulante','=','postulante.id')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->where('requerimiento.id_convocatoria',$id_conv)->get();
        
        return view('admConvocatoria.admPostulantes',compact('listPostulantes','listaAux','listaRotulos'));
    }


    public function create(Request $request){
        
        $existe = Postulante::where('ci',request()->input('ci'))
            ->orWhere('cod_sis',request()->input('cod-sis'))->get();
        $existeConvo = [];
        if($existe->isNotEmpty()){
            foreach($existe as $postu){
                $existeConvo = Postulante_conovocatoria::
                    where('id_convocatoria',request()->input('id-conv-postulante'))
                    ->where('id_postulante',$postu['id'])->get();
                if($existeConvo->isNotEmpty()){
                    break;
                }
            }
            if(count($existeConvo)>0){
                request()->validate([
                    'ci' => 'unique:postulante,ci'
                ],[
                    'ci.unique' => 'El postulante ya se encuentra registrado.'
                ]); 
            }
        }
        
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
        $postulante_con->calificando_merito =  false;
        $postulante_con->calificando_requisito =  false;
        $postulante_con->save();
        $requisitos = (new RequisitoComp)->getRequisitos(session()->get('convocatoria'));

        $arreglo = request()->input('auxiliaturas'); 
        foreach ($arreglo as $aux) {
            $postulante_aux = new Postulante_auxiliatura();
            $postulante_aux->id_postulante = $postulante->id;
            $postulante_aux->id_auxiliatura = $aux;
            //$postulante_aux->observacion = "ninguna";
            $postulante_aux->save();
            $post_calf_conoc_fin = new PostuCalifConocFinal();
            $post_calf_conoc_fin->id_convocatoria = session()->get('convocatoria');
            $post_calf_conoc_fin->id_postulante = $postulante->id; 
            $post_calf_conoc_fin->id_auxiliatura = $aux;
            $post_calf_conoc_fin->save();
            foreach ($requisitos as $requisito){
                $post_calf_requisitos = new Postulante_req_aux();
                $post_calf_requisitos->id_postulante_auxiliatura = $postulante_aux->id;
                $post_calf_requisitos->id_requisito = $requisito->id;
                $post_calf_requisitos->save();
            }

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
