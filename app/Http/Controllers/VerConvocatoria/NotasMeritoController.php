<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postulante;
use App\Models\Postulante_conovocatoria;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utils\Convocatoria\MeritoComp;

class NotasMeritoController extends Controller
{
    public function index() {
        $postulantes= Postulante::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->where('postulante_auxiliatura.habilitado',true)
        ->where('estado','publicado')
        ->orderBy('postulante.apellido','ASC')
        ->get() ;
        $postulantes = collect($postulantes)->unique('id');
        return view('verConvocatoria.notasMerito', compact('postulantes'));
    }

    public function meritos($idEst){
        $id= session()->get('convocatoria');
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

        return view('verConvocatoria.notasMeritoEstudiante',compact('id', 'lista', 'estudiante', 'listaMeritos','notaFinalMerito'));
    
    }
}
