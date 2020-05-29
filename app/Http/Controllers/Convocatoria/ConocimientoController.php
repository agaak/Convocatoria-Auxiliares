<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Convocatoria\ConocimientoCreateRequest;
use App\Tematica;
use App\Porcentaje;

class ConocimientoController extends Controller
{
    public function knowledgeRating(Request $request){
        $requests =DB::table('requerimiento')->select('auxiliatura.nombre_aux','auxiliatura.cod_aux')
            ->where('id_convocatoria', $request->session()->get('convocatoria'))
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id') ->get();    
        $tematics = Tematica::get();
        $porcen = Porcentaje::select('id_requerimiento','porcentaje','id_tematica','id_requerimiento','tematica.nombre')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->join('tematica','porcentaje.id_tematica','=','tematica.id');
        $porcentajes = $porcen->get();
        $tems = $porcen->select('nombre','id_tematica')->groupBy('nombre','id_tematica')->get();
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

    public function knowledgeRatingAuxUpdate(Request $request){
        //DB::table('porcentaje')->where('id', $request->input('id-porcentaje'))->update([
        //    'porcentaje' => $request->input('porcentaje'),
        //]);
        return back();
    }
    
}