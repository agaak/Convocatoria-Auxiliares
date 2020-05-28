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
        $requests =DB::table('requerimiento')->where('id_convocatoria', $request->session()->get('convocatoria'))->get();
       
        $tematics = Tematica::select('tematica','tematica.id')->join('porcentaje', 'tematica.id', '=', 'porcentaje.id_tematica')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->join('convocatoria', 'convocatoria.id', '=', 'requerimiento.id_convocatoria')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->groupBy('tematica','tematica.id')
            ->get();

        $porcentajes = Porcentaje::select('id_requerimiento','porcentaje','id_tematica','porcentaje.id')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->join('convocatoria', 'convocatoria.id', '=', 'requerimiento.id_convocatoria')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->groupBy('id_requerimiento','porcentaje','id_tematica','porcentaje.id')
            ->get();
        return view('convocatory.conocimientos', compact('tematics', 'requests','porcentajes'));
    }

    public function knowledgeRatingTematicValid(Request $request){
        $tematic = Tematica::create(['tematica' => $request->input('nombre') ]);
        $requests=DB::table('requerimiento')->where('id_convocatoria', $request->session()->get('convocatoria'))->get();
        foreach($requests as $item){
            Porcentaje::create([
                'id_requerimiento' => $item->id,
                'id_tematica' => $tematic->id,
                'porcentaje' => $request->input('porcentaje')
            ]);
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
