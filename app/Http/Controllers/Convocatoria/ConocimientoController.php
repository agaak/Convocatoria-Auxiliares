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
    public function index(Request $request){
        $id_conv = $request->session()->get('convocatoria');
        $conv = DB::table('convocatoria')->find($id_conv);
        $porcentajesConvocatoria = Calificacion_final::where('id_convocatoria',$id_conv)->first();
        $rutaPDF = $conv->ruta_pdf;

        $utilsConocimiento= new ConocimientosComp;
        $list_aux = $utilsConocimiento->getRequerimientos($id_conv);
        $tems = $utilsConocimiento->getTems($id_conv);
        $porcentajes = $utilsConocimiento->getPorcentajes($id_conv);
        $tematics = $utilsConocimiento->getTematicas($conv->id_tipo_convocatoria, $tems,$list_aux,$conv->id_unidad_academica);
        $areas = $utilsConocimiento->getAreas($conv->id_tipo_convocatoria,$conv->id_unidad_academica);
        return view('convocatory.conocimientos', compact('tematics','areas', 'list_aux','porcentajes','tems','porcentajesConvocatoria', 'rutaPDF', 'conv'));
    }

    public function knowledgeRatingTematicValid(Request $request){
        session()->put('id_conoc',$request->input('id-auxiliatura'));
        $areas = collect($request->input('area-aux'));
        $areas_dep = collect($request->input('area-2'));
        $id_req = Requerimiento::where('id_convocatoria',session()->get('convocatoria'))
            ->where('id_auxiliatura',$request->input('id-auxiliatura'))->value('id');
        foreach($request->get('area') as $area){
            $por = new Porcentaje(); 
            $por -> id_requerimiento = $id_req;
            $por -> id_auxiliatura =  $request->input('id-auxiliatura');
            $por -> id_tematica = $request->input('id-tematica'); 
            $por -> id_area = $area; 
            $por -> porcentaje = $areas->shift(); 
            if($areas_dep->contains($area) && collect($request->input('area'))
                                        ->contains($request->input($area.'-dep')[0])){
                $por -> id_porc_dependiente = $request->input($area.'-dep')[0]; 
            }
            $por -> save();
        }
        return back();
    }
    
    public function knowledgeRatingTematicDelete($id_tem, $id_aux){
        session()->put('id_conoc',$id_aux);
        $porcentajes = (new ConocimientosComp)->getPorcentajes(session()->get('convocatoria'));
        foreach($porcentajes as $porc){
            Porcentaje::where('id_tematica', $id_tem)->where('id_auxiliatura', $id_aux)->delete();
        }
        return back();
    }

    public function knowledgeRatingTematicUpdate(Request $request){
        session()->put('id_conoc',$request->input('id-auxiliatura-edit'));
        $areas_dep = collect($request->input('area-2'));
        $porcentajes = (new ConocimientosComp)->getPorcentajes(session()->get('convocatoria'));
        $porcentajes = $porcentajes->has($request->input('id-auxiliatura-edit'))? $porcentajes[$request->input('id-auxiliatura-edit')] : [];
        $porcentajes = collect($porcentajes)->groupBy('id_tematica')[$request->input('id-tematica-edit')];
        foreach($porcentajes as $porc){
            if(Porcentaje::where('id',$porc->id)->whereNotIn('id_area',
                $request->input('id-area-edit'))->get()->isEmpty()){

            } else {
                Porcentaje::where('id',$porc->id)->whereNotIn('id_area',$request->input('id-area-edit'))->delete();
            }
        }
        $id_req = Requerimiento::where('id_convocatoria',session()->get('convocatoria'))
            ->where('id_auxiliatura',$request->input('id-auxiliatura-edit'))->value('id');
        $porcentajes = $porcentajes->groupBy('id_area');
        $porc_edit = collect($request->input('porc-edit'));
        foreach($request->get('id-area-edit') as $id_area){
            $dependiente = $areas_dep->contains($id_area) && collect($request->input('id-area-edit'))
                    ->contains($request->input($id_area.'-dep-edit')[0]);
            if($porcentajes->has($id_area)){
                Porcentaje::where('id', $porcentajes[$id_area][0]['id'])->update([
                    'porcentaje' => $porc_edit->shift()
                ]);
                if($dependiente){ 
                    Porcentaje::where('id', $porcentajes[$id_area][0]['id'])->update([
                        'id_porc_dependiente' => $request->input($id_area.'-dep-edit')[0]
                    ]);
                } else {
                    Porcentaje::where('id', $porcentajes[$id_area][0]['id'])->update([
                        'id_porc_dependiente' => null
                    ]);
                }
            } else {
                $por = new Porcentaje(); 
                $por -> id_requerimiento = $id_req;
                $por -> id_auxiliatura =  $request->input('id-auxiliatura-edit');
                $por -> id_tematica = $request->input('id-tematica-edit'); 
                $por -> id_area = $id_area; 
                $por -> porcentaje = $porc_edit->shift(); 
                if($dependiente){
                    $por -> id_porc_dependiente = $request->input($id_area.'-dep-edit')[0]; 
                }
                $por -> save();
            }
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
            if(EventoImportante::where('id_convocatoria',$id_conv)
                ->where('titulo_evento', 'Presentación de Documentos')
                ->value('lugar_evento')[1] == '-'){
                request()->validate([
                    'finalizo' => 'required'
                ],[
                    'finalizo.required' => 'Modifique el evento Presentación de Documentos de la sección de eventos importantes.'
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