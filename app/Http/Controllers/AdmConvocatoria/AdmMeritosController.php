<?php

namespace App\Http\Controllers\AdmConvocatoria;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\Tipo_evaluador;
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
        $listEvaluadorMerit = EvaluadorConocimientos::select('evaluador.*')
            ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
            // ->join('tipo_conovocatoria','evaluador_conovocatoria.id_evaluador','=','tipo_conovocatoria.id_evaluador')
            ->where('evaluador_conovocatoria.id_convocatoria',$id_conv)
            ->join('tipo_evaluador','evaluador_conovocatoria.id','=','tipo_evaluador.id_evaluador_convocatoria')
            ->where('tipo_evaluador.id_rol_evaluador',1)
            ->get();
        $listEvaluadores = EvaluadorConocimientos::get();
        
        return view('admConvocatoria.admMeritos',compact('listEvaluadorMerit','listEvaluadores'));
    }

    public function create(AdmMeritosRequest $request) {
        $id_conv = session()->get('convocatoria');
        if (EvaluadorConocimientos::where('ci', '=', $request->input('adm-meritos-ci'))->exists()) {
            $idEvaluador = EvaluadorConocimientos::where('ci', '=', $request->input('adm-meritos-ci'))->value('id');
            DB::table('evaluador')->where('id', $idEvaluador)->update([
                'nombre' => $request->input('adm-meritos-nombre'),
                'apellido' => $request->input('adm-meritos-apellidos'),
                'correo' => $request->input('adm-meritos-correo'),
                'correo_alt' => $request->input('adm-meritos-correo-alter'),
            ]);
            if(EvaluadorConovocatoria::where('id_evaluador', '=', $idEvaluador)->exists()){
                
            }else{
                $evaluadorConovocatoria = new EvaluadorConovocatoria();
                $evaluadorConovocatoria->id_evaluador = $idEvaluador;
                $evaluadorConovocatoria->id_convocatoria = $id_conv;
                $evaluadorConovocatoria->save();
                $idEvaluadorConvocatoria = $evaluadorConovocatoria->id;
                Tipo_evaluador::create([
                    'id_rol_evaluador' => 1, 
                    'id_evaluador' => $idEvaluador,
                    'id_evaluador_convocatoria' => $idEvaluadorConvocatoria
                ]);
            }
        }else{
            $evaluador = new EvaluadorConocimientos();
            $evaluador->ci = $request->input('adm-meritos-ci');
            $evaluador->nombre = $request->input('adm-meritos-nombre');
            $evaluador->apellido = $request->input('adm-meritos-apellidos');
            $evaluador->correo = $request->input('adm-meritos-correo');
            $evaluador->correo_alt = $request->input('adm-meritos-correo-alter');
            $evaluador->save();
            $idEvaluador = $evaluador->id;

            $evaluadorConovocatoria = new EvaluadorConovocatoria();
            $evaluadorConovocatoria->id_evaluador = $idEvaluador;
            $evaluadorConovocatoria->id_convocatoria = $id_conv;
            $evaluadorConovocatoria->save();
            $idEvaluadorConvocatoria = $evaluadorConovocatoria->id;

            Tipo_evaluador::create([
                'id_rol_evaluador' => 1, 
                'id_evaluador' => $idEvaluador,
                'id_evaluador_convocatoria' => $idEvaluadorConvocatoria
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
        DB::table('tipo_evaluador')->where('id', 1)
                                       ->delete();
        return back();
    }
}
