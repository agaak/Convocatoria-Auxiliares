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
        
        $listEvaluadorMerit = EvaluadorConocimientos::select('evaluador.*','evaluador_conovocatoria.id as id_eva_conv')
            ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
            ->where('evaluador_conovocatoria.id_convocatoria',$id_conv)
            ->join('tipo_evaluador','evaluador_conovocatoria.id','=','tipo_evaluador.id_evaluador_convocatoria')
            ->where('id_rol_evaluador','1')->get();

        $listEvaluadores = EvaluadorConocimientos::get();
        
        return view('admConvocatoria.admMeritos',compact('listEvaluadorMerit','listEvaluadores'));
    }

    public function create(AdmMeritosRequest $request) {
        $id_conv = session()->get('convocatoria');
        $idEvaluador;
        if (EvaluadorConocimientos::where('ci', '=', $request->input('adm-meritos-ci'))->exists()) {
            $idEvaluador = EvaluadorConocimientos::where('ci', '=', $request->input('adm-meritos-ci'))
                                                    ->value('id');
            DB::table('evaluador')->where('id', $idEvaluador)->update([
                'nombre' => $request->input('adm-meritos-nombre'),
                'apellido' => $request->input('adm-meritos-apellidos'),
                'correo' => $request->input('adm-meritos-correo'),
                'correo_alt' => $request->input('adm-meritos-correo-alter'),
            ]);
        }else{
            $evaluador = new EvaluadorConocimientos();
            $evaluador->ci = $request->input('adm-meritos-ci');
            $evaluador->nombre = $request->input('adm-meritos-nombre');
            $evaluador->apellido = $request->input('adm-meritos-apellidos');
            $evaluador->correo = $request->input('adm-meritos-correo');
            $evaluador->correo_alt = $request->input('adm-meritos-correo-alter');
            $evaluador->save();
            $idEvaluador = $evaluador->id;
        }
        if(EvaluadorConovocatoria::where('id_evaluador', '=', $idEvaluador)
                                ->where('id_convocatoria', '=', $id_conv)->exists()){
            $idEvaluadorConvocatoria = EvaluadorConovocatoria::where('id_evaluador', '=', $idEvaluador)
                                    ->where('id_convocatoria', '=', $id_conv)->first()->id;
        }else{
            $evaluadorConovocatoria = new EvaluadorConovocatoria();
            $evaluadorConovocatoria->id_evaluador = $idEvaluador;
            $evaluadorConovocatoria->id_convocatoria = $id_conv;
            $evaluadorConovocatoria->save();
            $idEvaluadorConvocatoria = $evaluadorConovocatoria->id;
        }
        if(Tipo_evaluador::where('id_rol_evaluador', '=', 1)
                           ->where('id_evaluador_convocatoria', '=', $idEvaluadorConvocatoria)
                           ->exists()){

        }else{
            Tipo_evaluador::create([
                'id_rol_evaluador' => 1, 
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
    
    public function delete($idEvaluador){
        $id_conv = session()->get('convocatoria');
        $evaluadorConvocatoria = EvaluadorConovocatoria::where('id_evaluador',$idEvaluador)
                                                ->where('id_convocatoria',$id_conv)->first();
        
        Tipo_evaluador::where('id_evaluador_convocatoria',$evaluadorConvocatoria->id)
                        ->where('id_rol_evaluador','1')->delete();

        if(Tipo_evaluador::where('id_evaluador_convocatoria',$evaluadorConvocatoria->id)
                            ->where('id_rol_evaluador','1')->get()->isEmpty()){
            EvaluadorConovocatoria::where('id_evaluador', $idEvaluador)
                                    ->where('id_convocatoria', $id_conv)
                                    ->delete();
        }
        return back();
    }
}
