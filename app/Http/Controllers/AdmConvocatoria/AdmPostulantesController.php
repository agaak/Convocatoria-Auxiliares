<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Models\Postulante;
use App\Models\PrePostulante;
use App\Models\Auxiliatura;
use App\Models\Convocatoria;
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
        $this->middleware(['auth', 'roles:secretaria']);
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
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->where('requerimiento.id_convocatoria',$id_conv)->get();
        
        $prePostulante = Convocatoria::find($id_conv);
        return view('admConvocatoria.admPostulantes',compact('listPostulantes','listaAux','listaRotulos','prePostulante'));
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
            $postulante_aux->id_convocatoria = session()->get('convocatoria');
            $postulante_aux->save();

            foreach ($requisitos as $requisito){
                $post_calf_requisitos = new Postulante_req_aux();
                $post_calf_requisitos->id_postulante_auxiliatura = $postulante_aux->id;
                $post_calf_requisitos->id_requisito = $requisito->id;
                $post_calf_requisitos->save();
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

    public function habilitar($id) {
        $convocatoria = Convocatoria::find($id);
        if ($convocatoria->pre_posts_habilitado) {
            Convocatoria::where('id', $id)->update([
                'pre_posts_habilitado' => false
            ]);
        } else {
            Convocatoria::where('id', $id)->update([
                'pre_posts_habilitado' => true
            ]);
        }
        return back();
    }
}
