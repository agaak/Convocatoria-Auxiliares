<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Postulante;
use App\Models\Auxiliatura;
use App\Models\Porcentaje;
use App\Models\PostuCalifConoc;
use App\Models\Postulante_auxiliatura;

class NotasAuxiliaturaController extends Controller
{
    public function index() {
        $id_conv = session()->get('convocatoria');
        
        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id', 'calf_fin_postulante_conoc.id_auxiliatura',
        'nota_final_conoc', 'calf_fin_postulante_conoc.id as id_nota_fin_conoc')
        
        ->join('calf_fin_postulante_conoc','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
        ->where('calf_fin_postulante_conoc.id_convocatoria',$id_conv)
        ->get();

        
        foreach($listaAux as $aux){
            $tems = Porcentaje::select('porcentaje.id_tematica','tematica.nombre','porcentaje.id as id_por')
            ->join('requerimiento','requerimiento.id','=','porcentaje.id_requerimiento')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->where('porcentaje.id_auxiliatura',$aux->id)
            ->join('tematica','tematica.id','=','porcentaje.id_tematica')
            ->orderBy('id_por','ASC')->get();
            $aux->tematicas = $tems;
        }
        
        foreach($listaPost as $postulante){
            $calf_tems = PostuCalifConoc::where('id_postulante',$postulante->id)
            ->where('id_calf_final',$postulante->id_nota_fin_conoc)
            ->orderBy('id_porcentaje','ASC')
            ->get();
            $postulante->notas_tems = $calf_tems;
        }
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
       
        return view('verConvocatoria.notasConocimientoA',compact('listaAux','listaPost'));
    }
}
