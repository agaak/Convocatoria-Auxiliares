<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Convocatoria\ConocimientoCreateRequest;
use App\Models\Tematica;
use App\Models\Porcentaje;
use App\Models\Calificacion_final;
use App\Models\Convocatoria;
use App\Models\Documento;
use App\Models\EventoImportante;
use App\Http\Requests\Convocatoria\TematicaEditRequest;
use App\Http\Controllers\Utils\Convocatoria\ConocimientosComp;
use App\Models\Merito;
use App\Models\Requerimiento;
use App\Models\Requisito;

class ConocimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('view');
    }
    public function knowledgeRating(Request $request){
        $id_conv = $request->session()->get('convocatoria');
        $convActual = DB::table('convocatoria')->find($id_conv);

        $rutaPDF = $convActual->ruta_pdf;

        $tipo = $convActual->id_tipo_convocatoria;
        $utilsConocimiento= new ConocimientosComp;
        $requests = $utilsConocimiento->getRequerimientos($id_conv);
        $porcentajes = $utilsConocimiento->getPorcentajes($id_conv);
        $tems = $utilsConocimiento->getItems($id_conv);

        $tem_res = [];
        foreach($tems as $tem){
            array_push($tem_res, $tem->id);    
        }
        $tematics=Tematica::where('id_unidad_academica',1)
            ->where('id_tipo_convocatoria',$tipo)
            ->where('habilitado', true)
            ->whereNotIn('id', $tem_res)->get();
            
        $porcentajesConvocatoria = Calificacion_final::where('id_convocatoria',session()
                                                    ->get('convocatoria'))->first();
        return view('convocatory.conocimientos', compact('tematics', 'requests','porcentajes','tems','porcentajesConvocatoria', 'rutaPDF'));
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
            $por -> porcentaje = 0; 
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
        } else {
            request()->validate([
                'finalizo' => 'required'
            ],[
                'finalizo.required' => 'Error al intentar actualizar, los porcentajes no es 100%.'
            ]);
        } 
        return back();
    }
    
    public function knowledgeRatingFinish(Request $request){
        
        $id_conv = session()->get('convocatoria');
        
        $convActual = Convocatoria::find($id_conv);

        if (!$convActual->ruta_pdf) {
            if(str_contains($request->file('upload-pdf')->getClientOriginalName(),'.pdf')){
                Convocatoria::where('id', $id_conv)->update([
                    'ruta_pdf' => $request->file('upload-pdf')->storeAs('public', $convActual->id.request()->file('upload-pdf')->getClientOriginalName())
                ]);
            } else {
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'El archivo debe ser PDF.'
                ]);
            }
        }

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
        
            if(!Requerimiento::where('id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la seccion de requerimientos.'
                ]);  
            }
            if(!Requisito::where('id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la seccion de requisitos.'
                ]);  
            }
            if(!Documento::where('id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la seccion de documentos.'
                ]);  
            }
            if(!EventoImportante::where('id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la seccion de eventos importantes.'
                ]);  
            }
            if(!Merito::where('id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la seccion de calificaion de meritos.'
                ]);  
            }
            $meritos = Merito::where('id_convocatoria', $id_conv)->get();
            $control_merit = true;
            foreach($meritos as $merito){
                if($merito->id_submerito == null){
                    $subMeritos = Merito::where('id_convocatoria', $id_conv)->where('id_submerito', $merito->id)->sum('porcentaje');
                    $control_merit = $control_merit && $merito->porcentaje == $subMeritos;
                }
            }
            if(!$control_merit){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'Falta llenar la suma de los porcentajes de algunos sub-meritos.'
                ]);  
            }
            if(! Merito::where('id_convocatoria',$id_conv)->where('id_submerito', null)->sum('porcentaje') == 100){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'La suma de los porcentajes de meritos no es el 100%.'
                ]);  
            }
            if(! Calificacion_final::where('id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la nota final en la seccion de meritos.'
                ]);  
            }
            if(! Porcentaje::join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
                ->where('requerimiento.id_convocatoria',$id_conv)->exists()){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'No lleno la seccion de calificacion de conocimientos.'
                ]);  
            }
           
        if($porcen_min->isNotEmpty() || $porcen_max->isNotEmpty()){
            request()->validate([
                'finalizo' => 'required'
            ],[
                'finalizo.required' => 'La suma de los porcentajes de las tematicas de una auxiliaturas no es el 100%.'
            ]);
        }
        Convocatoria::where('id', $id_conv)->update([
            'creado' => true
        ]);
        return redirect()->route('convocatoria.index');
    }

    public function knowledgeRatingPdf(Request $request){
        $id_conv = session()->get('convocatoria');
        DB::table('convocatoria')->where('id', $id_conv)->update([
            'ruta_pdf' => $request -> file('documento') -> store('public/')
        ]);        
        return back();
    }
}