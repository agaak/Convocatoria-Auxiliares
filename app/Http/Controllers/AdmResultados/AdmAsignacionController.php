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
        $condicion=$this->hayItems(request()->get('ida'));
        if($condicion==1){
            $errores = ["No hay cupos para esta auxiliatura"];
        }elseif ($condicion==2) {
            
            $res= Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                        ->where('id_postulante', request()->get('id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->update(['item' => 1]);
        }else{
            $res= Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                        ->where('id_postulante', request()->get('id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->increment('item');
        }
        return back();
    }

    public function hayItems($ida){
        $itemsTotal= Requerimiento::select('cant_aux')
                    ->where('requerimiento.id_auxiliatura',$ida)
                    ->where('requerimiento.id_convocatoria', session()->get('convocatoria'))
                    ->get();
        $itemsOcupados= Postulante_auxiliatura::select(DB::raw('sum(postulante_auxiliatura.item) as cantidad'))
                        ->where('postulante_auxiliatura.id_auxiliatura',$ida)
                        ->where('postulante_auxiliatura.id_convocatoria', session()->get('convocatoria'))
                        ->whereNotNull('postulante_auxiliatura.item')
                        ->get();
        if($itemsTotal[0]->cant_aux == $itemsOcupados[0]->cantidad)
            $rs=1;
        elseif ($itemsOcupados[0]->cantidad == null) 
            $rs=2;
        else
            $rs=3;
        return $rs;
    }   

    public function quitar(){ 

        $res= Postulante_auxiliatura::select('item')
                                        ->where('id_auxiliatura', request()->get('ida'))
                                        ->where('id_postulante', request()->get('id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->get();
        $condicion= $res[0]->item;
        if ($condicion===1) {
            $res= Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                        ->where('id_postulante', request()->get('id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->update(['item' => 0]);
        }elseif ($condicion>1) {  
              
            $res= Postulante_auxiliatura::where('id_auxiliatura', request()->get('ida'))
                                        ->where('id_postulante', request()->get('id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->decrement('item');
        }else{ 
        }
        return back();
    }

    public function prePostulantes() {

        PrePostulante::where('id_convocatoria', session()->get('convocatoria'))->delete();

        return back();
    }

    public function invitar(Request $request) {
        $condicion=$this->hayItems(request()->get('asig_id_auxiliatura'));
        if($condicion==1){
            $errores = ["No hay cupos para esta auxiliatura"];
        }elseif ($condicion==2) {
            
            $res= Postulante_auxiliatura::where('id_auxiliatura', request()->get('asig_id_auxiliatura'))
                                        ->where('id_postulante', request()->get('post-id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->update(['item' => 1]);
        }else{
            $res= Postulante_auxiliatura::where('id_auxiliatura', request()->get('asig_id_auxiliatura'))
                                        ->where('id_postulante', request()->get('post-id'))
                                        ->where('id_convocatoria', session()->get('convocatoria'))
                                        ->increment('item');
        }
        // return $request;
        return back();
    }
}
