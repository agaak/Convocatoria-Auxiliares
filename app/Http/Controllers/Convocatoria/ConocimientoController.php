<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Convocatoria\ConocimientoCreateRequest;
use App\Tematica;
use App\Porcentaje;
use App\Http\Requests\Convocatoria\TematicaEditRequest;

class ConocimientoController extends Controller
{
    public function knowledgeRating(Request $request){
        $id_conv = $request->session()->get('convocatoria');
        $tipo = DB::table('convocatoria')->where('id',$id_conv)
            ->value('id_tipo_convocatoria');
        $requests =DB::table('requerimiento')->select('auxiliatura.nombre_aux','auxiliatura.cod_aux','requerimiento.id')
            ->where('id_convocatoria',$id_conv)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id') ->get();    
        $porcen = Porcentaje::select('id_requerimiento','porcentaje','id_tematica','id_requerimiento','tematica.nombre')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->join('tematica','porcentaje.id_tematica','=','tematica.id');
        $porcentajes = $porcen->get();
        $tems = $porcen->select('nombre','id_tematica')->groupBy('nombre','id_tematica')->get();
        $tem_res = [];
        foreach($tems as $tem){
            array_push($tem_res, $tem->id_tematica);    
        }
        $tematics=DB::table('tematica')->where('id_unidad_academica',1)
            ->where('id_tipo_convocatoria',$tipo)
            ->whereNotIn('id', $tem_res)->get();
        return view('convocatory.conocimientos', compact('tematics', 'requests','porcentajes','tems'));
    }

    public function knowledgeRatingTematicValid(ConocimientoCreateRequest $request){
        $res = DB::table('tematica')
            ->where('tematica.id',$request->get('id-tem')) 
            ->join('porcentaje', 'tematica.id','=','porcentaje.id_tematica')
            ->join('requerimiento','porcentaje.id_requerimiento','=','requerimiento.id')
            ->where('requerimiento.id_convocatoria','=',$request->session()->get('convocatoria'))
            ->get();
        if(count($res)==0){
            $requests=DB::table('requerimiento')->where('id_convocatoria', $request->session()->get('convocatoria'))->get();
            foreach($requests as $item){
            $por = new Porcentaje(); 
            $por -> id_requerimiento = $item->id;
            $por -> id_auxiliatura =  $item->id_auxiliatura;
            $por -> id_tematica = $request->get('id-tem'); 
            $por -> porcentaje = $request->get('porcentaje'); 
            $por -> save();
            }
        }
        return back();
    }
    


    public function knowledgeRatingTematicDelete($id){
        DB::table('porcentaje')->where('id_tematica', $id)->delete();
        return back();
    }

    public function knowledgeRatingTematicUpdate(TematicaEditRequest $request, $id){
        $id_conv = $request->session()->get('convocatoria');
        $porcentaje = Porcentaje::select('porcentaje.id')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->where('id_tematica', $request->input('id-tem'))->get();
        foreach($porcentaje as $item){
            DB::table('porcentaje')->where('id', $item->id)->update([
                'id_tematica' => $request->input('nombre-tem')
            ]);
        }  
        return back();
    }

    public function knowledgeRatingAuxUpdate(Request $request){
        $tematics = collect($request->input('id-tem'));
        $porcentaje = $request->input('porcentaje');
        foreach($porcentaje as $por){
            DB::table('porcentaje')->where([['id_requerimiento', $request->input('id-req')],['id_tematica', $tematics->shift()]])
                ->update([
                'porcentaje' => $por,
            ]);
        }
        return back();
    }
    
    public function knowledgeRatingFinish(){
        $id_conv = session()->get('convocatoria');
        $porcen_max = Porcentaje::select(DB::raw('sum(porcentaje) as porc_count, requerimiento.id_auxiliatura'))
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->groupBy('requerimiento.id_auxiliatura')
            ->groupBy('requerimiento.id_auxiliatura')
            ->havingRaw('SUM(porcentaje) > 100')->get();
        $porcen_min = Porcentaje::select(DB::raw('sum(porcentaje) as porc_count, requerimiento.id_auxiliatura'))
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->groupBy('requerimiento.id_auxiliatura')
            ->groupBy('requerimiento.id_auxiliatura')
            ->havingRaw('SUM(porcentaje) < 100')->get();
        if($porcen_min->isEmpty() && $porcen_max->isEmpty()){
            return redirect()->route('convocatoria.index');   
        }
        return back(); //Ccorregir los datos
    }
}