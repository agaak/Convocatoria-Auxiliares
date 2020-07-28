<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Convocatoria;
use App\Models\Postulante;
use App\Models\Tematica;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use App\Models\Postulante_auxiliatura;
use App\Models\PrePostulante;
use App\Models\PostuCalifConocFinal;
use App\Models\PostuCalifConoc;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;

class AdmAsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }

    public function index()
    {   
        $id_conv = session()->get('convocatoria');
        $conv = Convocatoria::find($id_conv);
        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id','cant_aux','horas_mes')
            ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
            ->where('id_convocatoria',$id_conv)->get(); 
        foreach($listaAux as $aux){
            $itemsOcupados = Postulante_auxiliatura::where('id_auxiliatura',$aux->id)
                ->where('id_convocatoria', session()->get('convocatoria'))
                ->whereNotNull('item')->sum('item');
            $aux->items_libres = $aux->cant_aux - $itemsOcupados;
        }
        $tematicas = (new ConocimientosComp)->getTems($id_conv);
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
        'postulante_auxiliatura.calificacion','postulante_auxiliatura.item','postulante_auxiliatura.id_auxiliatura')
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->where('postulante_auxiliatura.habilitado', true)
        ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
        ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
        ->whereNotNull('postulante_auxiliatura.calificacion')
        ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','postulante_auxiliatura.calificacion','postulante_auxiliatura.item')
        ->orderBy('postulante_auxiliatura.calificacion', 'DESC')->get();
        foreach($listaPost as $postulante){
            $id_calf_fin_conoc = PostuCalifConocFinal::where('id_postulante',$postulante->id)->where('id_convocatoria',$id_conv)
                ->where('id_auxiliatura',$postulante->id_auxiliatura)->value('id');
            $test = PostuCalifConoc::where('id_calf_final',$id_calf_fin_conoc)
                ->where('estado','entregado')->get()->isNotEmpty();
            $test2 = PostuCalifConoc::where('id_calf_final',$id_calf_fin_conoc)
                ->where('estado','publicado')->count();
            $test3 = count($tematicas[$postulante->id_auxiliatura][0]['areas']);
            if($test || ($test2 < $test3)){
                $listaPost = [];
                break;
            }
            if($postulante->item == null || $postulante->item == 0){
                if($postulante->calificacion < 50.5){
                    $postulante->estado = "Postulante Reprobado";   
                } else {
                    $postulante->estado = "Postulante Aprobado";
                }
            } else {
                $postulante->estado = "Auxiliaturas Asignadas";
            }
            $items_totales = Postulante_auxiliatura::select('id_auxiliatura', 'convocatoria.id', 'item as items')
                ->join('postulante','postulante.id','=','postulante_auxiliatura.id_postulante')
                ->where('postulante.ci',  $postulante->ci)->whereNotNull('item') 
                ->join('postulante_conovocatoria','postulante_auxiliatura.id_postulante','=','postulante_conovocatoria.id_postulante')
                ->join('convocatoria','convocatoria.id','=','postulante_conovocatoria.id_convocatoria')
                ->where('convocatoria.gestion',$conv->gestion)->get();
            $total_horas = 0;
            foreach($items_totales as $item){
                $total_horas += Requerimiento::where('id_convocatoria',$item->id)
                    ->where('id_auxiliatura',$item->id_auxiliatura)->value('horas_mes') * $item->items;
            }
            $postulante->horas = $total_horas;
        }
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        // return $listaPost;
        $finalizado = Convocatoria::where('id',session()->get('convocatoria'))->value('finalizado');
        
        return view('admResultados.admAsignaciones',compact('listaAux','listaPost','conv','finalizado'));
    }

    public function asignar(){
        session()->put('id_tab',request()->get('ida'));
        $nom_post=Postulante::find(request()->get('id'));
        $nom_post=$nom_post->nombre.' '.$nom_post->apellido;
        request()->validate([
            'horas' => 'required|integer|between:1,80',
        ],[
            'horas.between' => 'La suma de las horas acumuladas del estudiante '.$nom_post.' sobrepasa del limite de 80 hrs'
        ]);
        if($this->hayItems(request()->get('ida'))) {
            $item = Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                            ->where('id_postulante', request()->get('id'))->value('item');
            if ($item == null) {
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                            ->where('id_postulante', request()->get('id'))
                                            ->update(['item' => 1]);
            }else{
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                        ->where('id_postulante', request()->get('id'))
                                        ->increment('item');
            }
        } else {
            request()->validate([
                'horas' => 'required|integer|between:0,1',
            ],[
                'horas.between' => 'No hay cupos para esta auxiliatura'
            ]);
        }
        return back();
    }

    public function hayItems($ida){
        $itemsTotal= Requerimiento::where('requerimiento.id_auxiliatura',$ida)
                    ->where('requerimiento.id_convocatoria', session()->get('convocatoria'))->value('cant_aux');

        $itemsOcupados= Postulante_auxiliatura::where('id_auxiliatura',$ida)
            ->where('id_convocatoria', session()->get('convocatoria'))
            ->whereNotNull('item')->sum('item');

        return $itemsTotal - $itemsOcupados > 0;
    }   

    public function quitar(){ 
        session()->put('id_tab',request()->get('ida'));
        $item = Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                            ->where('id_postulante', request()->get('id'))->value('item');
        if($item != 0 || $item == null){
            if ($item === 1 || $item == null) {
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                            ->where('id_postulante', request()->get('id'))
                                            ->update(['item' => null]);
            }else{
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                            ->where('id_postulante', request()->get('id'))
                                            ->decrement('item');
            }
        }
        return back();
    }

    public function prePostulantes() {

        PrePostulante::where('id_convocatoria', session()->get('convocatoria'))->delete();
        Convocatoria::where('id',session()->get('convocatoria'))->update(['finalizado' => true]);
        return back();
    }

    public function invitar(Request $request) {
        if($this->hayItems(request()->get('asig_id_auxiliatura'))){
            $item = Postulante_auxiliatura::where('id_auxiliatura', request()->get('asig_id_auxiliatura'))
                            ->where('id_postulante', request()->get('post-id'))->value('item');
            if ($item == null) {
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('asig_id_auxiliatura'))
                                            ->where('id_postulante', request()->get('post-id'))
                                            ->where('id_convocatoria', session()->get('convocatoria'))
                                            ->update(['item' => 1]);
            }else{
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('asig_id_auxiliatura'))
                                            ->where('id_postulante', request()->get('post-id'))
                                            ->where('id_convocatoria', session()->get('convocatoria'))
                                            ->increment('item');
            }
        } else {
            $errores = ["No hay cupos para esta auxiliatura"];
        }
        return back();
    }
}
