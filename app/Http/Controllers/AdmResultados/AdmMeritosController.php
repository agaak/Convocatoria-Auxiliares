<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;
use App\Models\Calificacion_final;
use App\Models\PostuCalifMeritoFinal;
use App\Models\Postulante_auxiliatura;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utils\Convocatoria\MeritoComp;
use App\Models\Convocatoria;

class AdmMeritosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {   
        $publicado = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','publicado')->get()->isNotEmpty();
        $entregado = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','entregado')->get()->isNotEmpty();
        $id_conv = session()->get('convocatoria');
        $postulantes= Postulante::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->where('postulante_auxiliatura.habilitado',true);
        if($publicado){
            $postulantes=$postulantes->where('estado','publicado')
            ->orderBy('postulante.apellido','ASC')->get() ;
        }else{
            if($entregado){
                $postulantes=$postulantes->where('estado','entregado') 
                ->orderBy('postulante.apellido','ASC')->get() ;
            }else{
                $postulantes=[];
            }
        }
        $postulantes = collect($postulantes)->unique('id');
        
        $publicado = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','publicado')->get()->isNotEmpty();
        $entregado = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','entregado')->get()->isNotEmpty();

        $conv = Convocatoria::find($id_conv);

        return view('admResultados.admResMeritos', compact('postulantes','publicado','entregado','conv'));
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

        $conv = Convocatoria::find($id);
        return view('admResultados.notasMeritoEstudiante',compact('id', 'lista', 'estudiante', 'listaMeritos','notaFinalMerito', 'conv'));
    
    }

    public function publicar(){
        $postulantes = PostuCalifMeritoFinal::where('id_convocatoria', session()->get('convocatoria'))
            ->whereNotNull('nota_final_merito')->get();
        $porcentaje = Calificacion_final::where('id_convocatoria', session()->get('convocatoria'))->value('porcentaje_merito'); 
        foreach($postulantes as $postulante){
            $porciento =  number_format($postulante->nota_final_merito*$porcentaje/100 ,2);
            $nota_fin = Postulante_auxiliatura::where('id_postulante', $postulante->id_postulante)->value('calificacion');
            $nota_fin += $porciento;
            Postulante_auxiliatura::where('id_postulante', $postulante->id_postulante)->update([
                'calificacion' => $nota_fin,
            ]); 
            PostuCalifMeritoFinal::where('id',$postulante->id)->update([
                'estado' => 'publicado',
            ]);
        }
        
        return back();
    }
}
