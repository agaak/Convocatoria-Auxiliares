<?php

namespace App\Http\Controllers\AdmConvocatoria;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\Http\Requests\AdmConvocatoria\AdmMeritosRequest;
use App\Http\Requests\AdmConvocatoria\AdmMeritosUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmMeritosController extends Controller
{
    public function index()
    {
        $id_conv = session()->get('convocatoria');
        
        $listEvaluadorMerit = EvaluadorConocimientos::select('evaluador.*')->where('id_tipo_evaluador','1')
            ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
            ->where('evaluador_conovocatoria.id_convocatoria',$id_conv)->get();
        $listEvaluadores = EvaluadorConocimientos::get();
        
        return view('admConvocatoria.admMeritos',compact('listEvaluadorMerit','listEvaluadores'));
    }

    public function create(AdmMeritosRequest $request) {
        $evaluador = new EvaluadorConocimientos();
        $id_conv = session()->get('convocatoria');
        $evaluador->id_tipo_evaluador = 1;
        $evaluador->ci = $request->input('adm-meritos-ci');
        $evaluador->nombre = $request->input('adm-meritos-nombre');
        $evaluador->apellido = $request->input('adm-meritos-apellidos');
        $evaluador->correo = $request->input('adm-meritos-correo');
        $evaluador->correo_alt = $request->input('adm-meritos-correo-alter');
        if (EvaluadorConocimientos::where('ci', '=', $request->input('adm-meritos-ci'))->exists()) {
            $idEvaluador = EvaluadorConocimientos::where('ci', '=', $request->input('adm-meritos-ci'))->value('id');
            DB::table('evaluador')->where('id', $idEvaluador)->update([
                'nombre' => $request->input('adm-meritos-nombre'),
                'apellido' => $request->input('adm-meritos-apellidos'),
                'correo' => $request->input('adm-meritos-correo'),
                'correo_alt' => $request->input('adm-meritos-correo-alter'),
            ]);
            EvaluadorConovocatoria::create([
                'id_evaluador' => $idEvaluador, 
                'id_convocatoria' => $id_conv
            ]);
        }else{
            $evaluador->save();
            $idEvaluador = $evaluador->id;
            EvaluadorConovocatoria::create([
                'id_evaluador' => $idEvaluador, 
                'id_convocatoria' => $id_conv
            ]);
        }
        return back();
    }

    public function update(AdmMeritosUpdateRequest $request){
        DB::table('evaluador')->where('id', $request->input('id-dato-edit'))->update([
            'ci' => $request->input('adm-meritos-ci-edit'),
            'nombre' => $request->input('adm-meritos-nombre-edit'),
            'apellido' => $request->input('adm-meritos-apellidos-edit'),
            'correo' => $request->input('adm-meritos-correo-edit'),
            'correo_alt' => $request->input('adm-meritos-correo-alter-edit')
        ]);
        return back();
    }
    
    public function delete($id){
        DB::table('evaluador_conovocatoria')->where('id_evaluador', $id)->delete();
        return back();
    }
}
