<?php

namespace App\Http\Controllers\AdmConvocatoria;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\Http\Requests\AdmConvocatoria\AdmMeritosRequest;
use App\Http\Requests\AdmConvocatoria\AdmMeritosUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmMeritosController extends Controller
{
    public function index()
    {
        $listEvaluador=DB::table('evaluador_conocimientos')
                            ->get();
        return view('admConvocatoria.admMeritos',compact('listEvaluador'));
    }

    public function create(AdmMeritosRequest $request) {
        $id_conv = session()->get('convocatoria');
        $evaluador = new EvaluadorConocimientos();
        $evaluador->ci = $request->input('adm-meritos-ci');
        $evaluador->nombre = $request->input('adm-meritos-nombre');
        $evaluador->apellido = $request->input('adm-meritos-apellidos');
        $evaluador->correo = $request->input('adm-meritos-correo');
        // $evaluador->correoAlter = $request->input('adm-meritos-correo-alter');
        $evaluador->save();
        return back();
    }

    public function update(AdmMeritosUpdateRequest $request){
        DB::table('evaluador_conocimientos')->where('id', $request->input('id-dato-edit'))->update([
            'ci' => $request->input('adm-meritos-ci-edit'),
            'nombre' => $request->input('adm-meritos-nombre-edit'),
            'apellido' => $request->input('adm-meritos-apellidos-edit'),
            'correo' => $request->input('adm-meritos-correo-edit')
            // 'correoAlter' => $request->input('adm-meritos-correo-alter-edit')
        ]);
        return back();
    }
    
    public function delete($id){
        DB::table('evaluador_conocimientos')->where('id', $id)->delete();
        return back();
    }
}
