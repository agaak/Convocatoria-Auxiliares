<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Convocatoria\ConocimientoCreateRequest;
use App\Tematica;
use App\Porcentaje;
use App\Calificacion_final;
use App\Documento;
use App\EventoImportante;
use App\Http\Requests\Convocatoria\TematicaEditRequest;
use App\Merito;
use App\Requerimiento;
use App\Requisito;

class ConocimientoController extends Controller
{
    public function knowledgeRating(Request $request){
        $id_conv = $request->session()->get('convocatoria');
        $tipo = DB::table('convocatoria')->where('id',$id_conv)
            ->value('id_tipo_convocatoria');
        $requests =DB::table('requerimiento')->select('auxiliatura.nombre_aux','auxiliatura.cod_aux','requerimiento.id')
            ->where('id_convocatoria',$id_conv)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')->orderBy('requerimiento.id','ASC')->get();    
        $porcentajes = Porcentaje::select('id_requerimiento','porcentaje.porcentaje','porcentaje.id_auxiliatura','id_tematica','tematica.nombre')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)->orderBy('id_requerimiento','ASC')
            ->join('tematica','porcentaje.id_tematica','=','tematica.id')
            ->orderBy('tematica.nombre','ASC')->get();
        $tems = Tematica::select('tematica.nombre','tematica.id')
            ->join('porcentaje','tematica.id','=','porcentaje.id_tematica')
            ->join('requerimiento','porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->groupBy('tematica.nombre','tematica.id')->orderBy('nombre','ASC')->get();
        $tem_res = [];
        foreach($tems as $tem){
            array_push($tem_res, $tem->id);    
        }
        $tematics=Tematica::where('id_unidad_academica',1)
            ->where('id_tipo_convocatoria',$tipo)
            ->whereNotIn('id', $tem_res)->get();
            
        $porcentajesConvocatoria = Calificacion_final::where('id_convocatoria',session()
                                                    ->get('convocatoria'))->first();
        return view('convocatory.conocimientos', compact('tematics', 'requests','porcentajes','tems','porcentajesConvocatoria'));
    }

    public function knowledgeRatingTematicValid(ConocimientoCreateRequest $request){
        $res = DB::table('tematica')
            ->where('tematica.id',$request->get('id-tematica')) 
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
            $por -> id_tematica = $request->get('id-tematica'); 
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
            ->where('id_tematica', $request->input('id-tematica-edit'))->get();
        foreach($porcentaje as $item){
            DB::table('porcentaje')->where('id', $item->id)->update([
                'id_tematica' => $request->input('nombre-tem')
            ]);
        }  
        return back();
    }

    public function knowledgeRatingAuxUpdate(Request $request){
        $tematics = collect($request->input('id-tem'));
        $porcentaje = $request->input('porcentaje-aux');
        if(collect($request->input('porcentaje-aux'))->sum()==100){
            foreach($porcentaje as $por){
                DB::table('porcentaje')->where([['id_requerimiento', $request->input('id-req')],
                    ['id_tematica', $tematics->shift()]])->update([
                    'porcentaje' => $por,
                ]);
            }
        } //false msg error en la cantidad
        return back();
    }
    
    public function knowledgeRatingFinish(Request $request){
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
        $controlMerito = Merito::where('id_convocatoria',$id_conv)->where('id_submerito', null)->sum('porcentaje') == 100;
        if(!$controlMerito){
            request()->validate([
                'finalizo' => 'required'
            ],[
                'finalizo.required' => 'La suma de los porcentajes de merito no es el 100%.'
            ]);  
        }
        $control = Requerimiento::where('id_convocatoria',$id_conv)->exists() && 
            Requisito::where('id_convocatoria',$id_conv)->exists() &&
            Documento::where('id_convocatoria',$id_conv)->exists() &&
            EventoImportante::where('id_convocatoria',$id_conv)->exists() &&
            Merito::where('id_convocatoria',$id_conv)->exists() &&
            Calificacion_final::where('id_convocatoria',$id_conv)->exists() &&
            Porcentaje::join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)->exists();
        if(!$control){
            request()->validate([
                'finalizo' => 'required'
            ],[
                'finalizo.required' => 'Tiene secciones sin completar.'
            ]);  
        }
        if($porcen_min->isNotEmpty() || $porcen_max->isNotEmpty()){
            request()->validate([
                'finalizo' => 'required'
            ],[
                'finalizo.required' => 'La suma de los porcentajes de las auxiliaturas no es el 100%.'
            ]);
        }
        if(str_contains($request->file('upload-pdf')->getClientOriginalName(),'.pdf')){
            DB::table('convocatoria')->where('id', $id_conv)->update([
                'ruta_pdf' => $request -> file('upload-pdf') -> store('public'),
                'creado' => true
            ]);
            return redirect()->route('convocatoria.index'); 
        } else {
            request()->validate([
                'finalizo' => 'required'
            ],[
                'finalizo.required' => 'El archivo debe ser PDF.'
            ]);
        }
    }

    public function knowledgeRatingPdf(Request $request){
        $id_conv = session()->get('convocatoria');
        DB::table('convocatoria')->where('id', $id_conv)->update([
            'ruta_pdf' => $request -> file('documento') -> store('public/')
        ]);
        
        return back();
    }
}