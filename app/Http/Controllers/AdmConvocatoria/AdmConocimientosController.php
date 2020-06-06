<?php

namespace App\Http\Controllers\AdmConvocatoria;

use App\Auxiliatura;
use App\Convocatoria;
use App\EvaluadorAuxiliatura;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\EvaluadorTematica;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdmConvocatoria\AdmConocimientosRequest;
use App\Porcentaje;
use App\Requerimiento;

class AdmConocimientosController extends Controller
{
    public function index()
    {
        $id_conv = session()->get('convocatoria');
        $listaMultiselect = [];
        $lista_tem_aux = [];
        $evalua = EvaluadorConocimientos::select('evaluador.*')->where('id_tipo_evaluador','2')
            ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
            ->where('evaluador_conovocatoria.id_convocatoria',$id_conv);
        $evaluadores = $evalua->get();
        $tipoConvocatoria  = Convocatoria::where('id',$id_conv)->value('id_tipo_convocatoria');
        if ($tipoConvocatoria  === 2) {
            $listaMultiselect = Requerimiento::select('auxiliatura.nombre_aux as nombre', 'requerimiento.id as id_unico')
            ->where('id_convocatoria', $id_conv)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')->get();
        
            $lista_tem_aux = $evalua->select('auxiliatura.nombre_aux as nombre','auxiliatura.id','auxiliatura.cod_aux as cod','evaluador.id as id_eva') 
            ->join('evaluador_auxiliatura','evaluador.id','=','evaluador_auxiliatura.id_evaluador')  
            ->join('auxiliatura','evaluador_auxiliatura.id_auxiliatura','=','auxiliatura.id')
            ->get();
        } else {
            $listaMultiselect = Porcentaje::select('id_tematica as id_unico', 'tematica.nombre')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria', $id_conv)
            ->join('tematica','porcentaje.id_tematica','=','tematica.id')->groupBy('tematica.nombre','id_tematica')->get();
        
            $lista_tem_aux = $evalua->select('tematica.nombre','tematica.id','evaluador.id as id_eva') 
            ->join('evaluador_tematica','evaluador.id','=','evaluador_tematica.id_evaluador')  
            ->join('tematica','evaluador_tematica.id_tematica','=','tematica.id')
            ->groupBy('tematica.id','evaluador.id')->get();
        }
        $listaEva = EvaluadorConocimientos::get();
        return view('admConvocatoria.admConocimientos', compact('listaEva', 'listaMultiselect','lista_tem_aux','evaluadores','tipoConvocatoria'));
    }

    public function inicio($id) {
        session()->put('convocatoria', $id) ;
        return redirect()->route('admConvocatoria');
    }

    public function store(AdmConocimientosRequest $request) {
        $id_conv = session()->get('convocatoria');
        $tipoConvocatoria  = Convocatoria::where('id',$id_conv)->value('id_tipo_convocatoria');
        $evaluador = new EvaluadorConocimientos();
        $evaluador->id_tipo_evaluador = 2;
        $evaluador->ci = $request->input('adm-cono-ci');
        $evaluador->nombre = $request->input('adm-cono-nombre');
        $evaluador->apellido = $request->input('adm-cono-apellidos');
        $evaluador->correo = $request->input('adm-cono-correo');
        if($request->input('adm-cono-correo2') != null){
            $evaluador->correo_alt = $request->input('adm-cono-correo2');
        }
        $evaluador->save();

        $idEvaluador = $evaluador->id;

        EvaluadorConovocatoria::create([
            'id_evaluador' => $idEvaluador, 
            'id_convocatoria' => $id_conv
        ]);

        $arreglo = $request->input('adm-cono-tipo');
        if ($tipoConvocatoria === 2) {
            for($i=0; $i<count($arreglo); $i++) {
                EvaluadorAuxiliatura::create([
                    'id_evaluador' => strval($idEvaluador),
                    'id_auxiliatura' => $arreglo[$i]
                ]);
            }

            $jsonTematicas = Porcentaje::select('id_tematica as id_unico')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria', $id_conv)
            ->join('tematica','porcentaje.id_tematica','=','tematica.id')->groupBy('tematica.nombre','id_tematica')->get();

            foreach($jsonTematicas as $item){
                EvaluadorTematica::create([
                    'id_evaluador' => strval($idEvaluador),
                    'id_tematica' => $item['id_unico']
                ]);
            }

        } else {
            for($i=0; $i<count($arreglo); $i++) {
                EvaluadorTematica::create([
                    'id_evaluador' => strval($idEvaluador),
                    'id_tematica' => $arreglo[$i]
                ]);
            }

            $jsonAuxiliaturas = Requerimiento::select('requerimiento.id as id_unico')
            ->where('id_convocatoria', $id_conv)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')->get();

            foreach($jsonAuxiliaturas as $item){
                EvaluadorAuxiliatura::create([
                    'id_evaluador' => strval($idEvaluador),
                    'id_auxiliatura' => $item['id_unico']
                ]);
            }
        }
        


        return back();
    }


    public function destroy($id)
    {
        EvaluadorConocimientos::find($id)->delete();
        return back();
    }
}
