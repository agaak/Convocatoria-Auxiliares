<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Postulante;
use App\PrePostulante;
use App\Auxiliatura;
use App\Postulante_auxiliatura;
use App\Postulante_conovocatoria;

class AdmPostulantesController extends Controller
{
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
        }
        return back();
    }
}
