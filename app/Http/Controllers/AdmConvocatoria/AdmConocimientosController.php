<?php

namespace App\Http\Controllers\AdmConvocatoria;


use App\Convocatoria;
use App\EvaluadorAuxiliatura;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\EvaluadorTematica;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdmConvocatoria\AdmConocimientosRequest;
use App\Porcentaje;
use App\Requerimiento;
use App\Tipo;

class AdmConocimientosController extends Controller
{
    public function index()
    {
        $tipoConvocatoria = Tipo::select('nombret_tipo')->where('id', Convocatoria::select('id_tipo_convocatoria')->where('id', 1)->value('id_tipo_convocatoria'))->value('nombret_tipo');
        $listaMultiselect;
        if (strcmp($tipoConvocatoria, 'Conv. Docencia') === 0) {
            $listaMultiselect = Requerimiento::select('auxiliatura.nombre_aux as nombre', 'requerimiento.id as id_unico')
            ->where('id_convocatoria', 1)
            ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')->get();
        } else {
            $listaMultiselect = Porcentaje::select('id_tematica as id_unico', 'tematica.nombre')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria', 1)
            ->join('tematica','porcentaje.id_tematica','=','tematica.id')->groupBy('tematica.nombre','id_tematica')->get();
        }
        
        $listaCi = EvaluadorConocimientos::select('ci')->get();
        return view('admConvocatoria.admConocimientos', compact('listaCi', 'listaMultiselect'));
    }

    public function store(AdmConocimientosRequest $request) {

        $tipoConvocatoria = Tipo::select('nombret_tipo')->where('id', Convocatoria::select('id_tipo_convocatoria')->where('id', 1)->value('id_tipo_convocatoria'))->value('nombret_tipo');
        
        $evaluador = new EvaluadorConocimientos();
        $evaluador->ci = $request->input('adm-cono-ci');
        $evaluador->nombre = $request->input('adm-cono-nombre');
        $evaluador->apellido = $request->input('adm-cono-apellidos');
        $evaluador->correo = $request->input('adm-cono-correo');
        $evaluador->save();

        $idEvaluador = $evaluador->id;

        EvaluadorConovocatoria::create([
            'id_evaluador' => $idEvaluador, 
            'id_convocatoria' => 1
        ]);

        $arreglo = $request->input('adm-cono-tipo');
        if (strcmp($tipoConvocatoria, 'Conv. Docencia') === 0) {
            for($i=0; $i<count($arreglo); $i++) {
                EvaluadorAuxiliatura::create([
                    'id_evaluador' => strval($idEvaluador),
                    'id_auxiliatura' => $arreglo[$i]
                ]);
            }

            $jsonTematicas = Porcentaje::select('id_tematica as id_unico')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria', 1)
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
            ->where('id_convocatoria', 1)
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
}
