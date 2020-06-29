<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;

class AdmAsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {   
        $id_conv = session()->get('convocatoria');
        
        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
        'postulante_auxiliatura.id_auxiliatura')
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->where('postulante_auxiliatura.habilitado', true)
        ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id')
        ->get();
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        return view('admConvocatoria.admAsignacionItems',compact('listaAux','listaPost'));
    }

}
