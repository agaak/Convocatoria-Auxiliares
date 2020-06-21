<?php

namespace App\Http\Controllers\Evaluador;

use App\EvaluadorConocimientos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Postulante;
use Illuminate\Support\Facades\DB;

class CalificacionMController extends Controller
{
    public function index($id){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        session()->put('convocatoria',$id);
        $postulantes= Postulante::select('postulante.*', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->get();
        return $postulantes;//view('evaluador.calificarMeritos', compact('convs', 'id', 'postulantes'));
    }

    public function calificarMeritos($idEst){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        $id= session()->get('convocatoria');
        $estudiante=DB::table('postulante')->where('id', $idEst)->get();
        $lista= DB::table('calificacion_merito')->select('merito.*', 'calificacion_merito.calificacion as calificacion')
                    ->join('merito', 'merito.id', '=', 'calificacion_merito.id_merito')
                    ->where('merito.id_convocatoria', $id)
                    ->where('calificacion_merito.id_postulante', $idEst)
                    ->get(); 
        return view('evaluador.calificarMeritosEstudiante',compact('convs','id', 'lista', 'estudiante'));
        
    }
}
