<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\EvaluadorConocimientos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postulante;
use App\Models\Postulante_conovocatoria;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utils\Convocatoria\MeritoComp;

class CalificacionMController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index($id){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        session()->put('convocatoria',$id);
        $postulantes= Postulante::select('postulante.*', 'calf_final_postulante_merito.nota_final_merito as nota', 'calf_final_postulante_merito.id as idNF')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->get();
        return view('evaluador.calificarMeritos', compact('convs', 'id', 'postulantes'));
    }

    public function calificarMeritos($idEst){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        $id= session()->get('convocatoria');

        $existe = Postulante_conovocatoria::where('id_postulante',$idEst)
            ->value('calificando_merito');
        if($existe){
            if(session()->has('id-pos')){
                if(session()->get('id-pos') != $idEst){
                    return redirect()->route('calificarMerito.index');
                }
            }else{
                return redirect()->route('calificarMerito.index');
            }
            // return redirect()->route('calificarMerito.index');
        }
        session()->put('id-pos',$idEst);
        Postulante_conovocatoria::where('id_postulante', $idEst)->update([
            'calificando_merito' => true,
        ]);

        $estudiante=DB::table('postulante')->where('id', $idEst)->get();
        $idNotaFinalMerito=DB::table('calf_final_postulante_merito')
                            ->where('calf_final_postulante_merito.id_postulante', $idEst)
                            ->where('calf_final_postulante_merito.id_convocatoria',$id)
                            ->select( 'calf_final_postulante_merito.*')
                            ->get();
        $notaFinalMerito=DB::table('calf_final_postulante_merito')
                            ->join('calificacion_merito', 'calificacion_merito.id_calf_final','=', 'calf_final_postulante_merito.id')
                            ->where('calf_final_postulante_merito.id_postulante', $idEst)
                            ->where('calf_final_postulante_merito.id_convocatoria',$id)
                            ->select(    
                                    DB::raw('COUNT(calificacion_merito.id_postulante) as numero'), 
                                    DB::raw('SUM(calificacion_merito.calificacion) as m_total'))
                            ->get();
        $lista= DB::table('calificacion_merito')->select('merito.*', 'calificacion_merito.calificacion as calificacion', 'calificacion_merito.id as idCalificacion')
                    ->join('merito', 'merito.id', '=', 'calificacion_merito.id_merito')
                    ->where('merito.id_convocatoria', $id)
                    ->where('calificacion_merito.id_postulante', $idEst)
                    ->get(); 
        $listaMeritos=(new MeritoComp)->getMeritos($id);

        return view('evaluador.calificarMeritosEstudiante',compact('convs','id', 'lista', 'estudiante', 'listaMeritos','idNotaFinalMerito','notaFinalMerito'));
    }

    public function calificarMeritoEspecifico(){
        $var= DB::table('calificacion_merito')->where('id', request()->get("idMerito"))
                    ->update(['calificacion' => request()->get("notaMerito")]);
        return back();
    }
    
    public function calificarMeritoFinal(){
        $id= session()->get('convocatoria');
        $var= DB::table('calf_final_postulante_merito')->where('id', request()->get('idNotaFinalMerito'))
                   ->update(['nota_final_merito' => request()->get("nota")]);

        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        session()->put('convocatoria',$id);
        $postulantes= Postulante::select('postulante.*', 'calf_final_postulante_merito.nota_final_merito as nota', 'calf_final_postulante_merito.id as idNF')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->get();
        Postulante_conovocatoria::where('id_postulante', session()->get('id-pos'))->update([
            'calificando_merito' => false,
        ]);
        session()->forget('id-pos');
        return redirect()->route('calificarMerito.index');
    }
}
