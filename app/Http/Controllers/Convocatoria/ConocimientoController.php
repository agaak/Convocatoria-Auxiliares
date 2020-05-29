<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Tematica;
use App\Porcentaje;

class ConocimientoController extends Controller
{
    public function knowledgeRating(Request $request){
        $requests =DB::table('requerimiento')->select('auxiliatura.nombre_aux','auxiliatura.cod_aux')
            ->where('id_convocatoria', $request->session()->get('convocatoria'))
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id') ->get();    
        $tematics = Tematica::get();
        $porcentajes = Porcentaje::select('id_requerimiento','porncentaje','id_tematica','id_requerimiento','tematica.nombre')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->join('tematica','porcentaje.id_tematica','=','tematica.id');
        /*$tematicsPor = Tematica::join('porcentaje','tematica.id','=','porcentaje.id_tematica')  
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->where('tematica.id','porcentaje.id_tematica')
            ->groupBy()->get();*/
        $tems = $porcentajes->select('nombre','id_tematica')->groupBy('nombre','id_tematica')->get();
        $porcentajes = $porcentajes->get();
        return view('convocatory.conocimientos', compact('tematics', 'requests','porcentajes','tems'));
    }

    public function knowledgeRatingTematicValid(Request $request){
        $requests=DB::table('requerimiento')->where('id_convocatoria', $request->session()->get('convocatoria'))->get();
        foreach($requests as $item){
            $por = new Porcentaje(); 
            $por -> id_requerimiento = $item->id;
            $por -> id_auxiliatura = $request->session()->get('convocatoria'); 
            $por -> id_tematica = $request->get('id-tem'); 
            $por -> porncentaje = $request->get('porcentaje'); 
            $por -> save();
            /*Porcentaje::create([
                'id_requerimiento' => $item->id,
                'id_auxiliatura' => $request->session()->get('convocatoria'),
                'id_tematica' => $request->input('id-tem'), 
                'porcentaje' => $request->input('porcentaje')
            ]);*/
        }
        return back();
    }
    


    public function knowledgeRatingTematicDelete($id){
        DB::table('tematica')->where('id', $id)->delete();
        return back();
    }

    public function knowledgeRatingAuxUpdate(Request $request){
        //DB::table('porcentaje')->where('id', $request->input('id-porcentaje'))->update([
        //    'porcentaje' => $request->input('porcentaje'),
        //]);
        return back();
    }
    
}
