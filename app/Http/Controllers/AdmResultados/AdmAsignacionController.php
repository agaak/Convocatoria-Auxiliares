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
        $tipoConv= Convocatoria::select('tipo_convocatoria.id')
                    ->join('tipo_convocatoria', 'tipo_convocatoria.id', '=', 'convocatoria.id_tipo_convocatoria')
                    ->where('convocatoria.id',$id_conv)
                    ->get();
                    
            $listaPostInvitados = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
            'postulante_auxiliatura.calificacion','postulante_auxiliatura.id_auxiliatura','postulante_auxiliatura.item')
            ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
            ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
            ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
            ->where('postulante_auxiliatura.habilitado', true)
            ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
            ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
            ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
            ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
            ->whereNotNull('postulante_auxiliatura.calificacion')
            ->where('postulante_auxiliatura.calificacion', '<', 51)
            ->groupby('postulante_auxiliatura.id_auxiliatura','postulante_auxiliatura.item','postulante.id','postulante_auxiliatura.calificacion')
            ->get();
            $listaPostInvitados = collect($listaPostInvitados)->groupBy('id_auxiliatura');
            
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
            ->where('postulante_auxiliatura.calificacion', '>=', 51)
            ->orWhere('postulante_auxiliatura.item', '!=', null)
            ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','postulante_auxiliatura.calificacion','postulante_auxiliatura.item')
            ->orderBy('postulante_auxiliatura.calificacion', 'DESC')
            ->get();
            $listaPost = collect($listaPost)->groupBy('id_auxiliatura');

        // return $listaPostInvitados;
          $conv = Convocatoria::find($id_conv);
        return view('admResultados.admAsignaciones',compact('listaAux','listaPost','conv','listaPostInvitados'));
    }

    public function asignar(){
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
            $errores = ["No hay cupos para esta auxiliatura"];
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

        $item = Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                            ->where('id_postulante', request()->get('id'))->value('item');
        if($item != null && $item != 0){
            
            if ($item === 1) {
                Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                            ->where('id_postulante', request()->get('id'))
                                            ->update(['item' => 0]);
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
