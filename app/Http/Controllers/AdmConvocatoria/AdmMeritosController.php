<?php

namespace App\Http\Controllers\AdmConvocatoria;

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
        
        $listEvaluadorMerit =  EvaluadorConocimientos::select('evaluador.*','evaluador_conovocatoria.id as id_eva_conv')
            ->join('evaluador_conovocatoria','evaluador.id','=','evaluador_conovocatoria.id_evaluador')
            ->where('evaluador_conovocatoria.id_convocatoria',$id_conv)
            ->join('tipo_evaluador','evaluador_conovocatoria.id','=','tipo_evaluador.id_evaluador_convocatoria')
            ->where('id_rol_evaluador','1')->get();

        $listEvaluadores = EvaluadorConocimientos::get();
        
        return view('admConvocatoria.admMeritos',compact('listEvaluadorMerit','listEvaluadores'));
    }

    public function create(Request $request) {
        $id_conv = session()->get('convocatoria');
        $idEvaluador = EvaluadorConocimientos::where('ci', $request->input('adm-cono-ci'))->value('id');
        if($idEvaluador == null){
            request()->validate([
                'adm-cono-ci' => 'min:4|max:9|unique:evaluador,ci',
                'adm-cono-nombre' => 'regex:/^[a-zA-Z\s]*$/',
                'adm-cono-apellidos' => 'regex:/^[\pL\s\-]+$/u',
                'adm-cono-correo' => 'email|unique:evaluador,correo',
                'adm-cono-correo2' => 'nullable|email'
            ],[
                'adm-cono-ci.min' => 'El campo CI contiene como minimo 4 carácteres.',
                'adm-cono-ci.max' => 'El campo CI contiene como maximo 10 carácteres.', 
                'adm-cono-ci.unique' => 'El ci ingresado ya existe.',
                'adm-cono-nombre.regex' => 'El campo Nombre solo permite letras y espacios en blanco.',
                'adm-cono-apellidos.regex' => 'El campo Apellidos solo permite letras y espacios en blanco.',
                'adm-cono-correo.unique' => 'El correo ingresado ya existe.',
                'adm-cono-correo.email' => 'El campo correo debe ser de tipo email.',
                'adm-cono-correo2.email' => 'El campo correo debe ser de tipo email.'
            ]);
            $evaluador = new EvaluadorConocimientos();
            $evaluador->ci = $request->input('adm-cono-ci');
            $evaluador->nombre = $request->input('adm-cono-nombre');
            $evaluador->apellido = $request->input('adm-cono-apellidos');
            $evaluador->correo = $request->input('adm-cono-correo');
            if($request->input('adm-cono-correo2') != null){
                $evaluador->correo_alt = $request->input('adm-cono-correo2');
            }
            $evaluador->save();
            $idEvaluador = $evaluador->id;
        }
        $idEvaluadorConvocatoria = EvaluadorConovocatoria::where('id_convocatoria',$id_conv)
            ->where('id_evaluador',$idEvaluador)->value('id');

        if($idEvaluadorConvocatoria == null){
            $eva_con = new EvaluadorConovocatoria();
            $eva_con->id_evaluador = $idEvaluador; 
            $eva_con->id_convocatoria = $id_conv;
            $eva_con->save();
            $idEvaluadorConvocatoria = $eva_con->id;
        }
        $tip_eva = Tipo_evaluador::where('id_evaluador_convocatoria',$idEvaluadorConvocatoria)->where('id_rol_evaluador',1)->get();
        if($tip_eva->isNotEmpty()){
            request()->validate([
                'adm-cono-ci' => 'unique:evaluador,ci'
            ],[
                'adm-cono-ci.unique' => 'El evaluador ya esta registrado.'
            ]);    
        }
        Tipo_evaluador::create([
            'id_rol_evaluador' => 1,
            'id_evaluador_convocatoria' => $idEvaluadorConvocatoria
        ]);
        return redirect()->route('admMeritos');
    }

    public function update(AdmMeritosUpdateRequest $request){
        EvaluadorConocimientos::where('id', $request->input('id-evaluador'))->update([
            'nombre' => $request->input('adm-cono-nombre-edit'),
            'apellido' => $request->input('adm-cono-apellidos-edit'),
            'correo' => $request->input('adm-cono-correo-edit'),
        ]);
        if($request->input('adm-cono-correo2-edit') != null){
            EvaluadorConocimientos::where('id', $request->input('id-evaluador'))->update([
                'correo_alt' => $request->input('adm-cono-correo2-edit'),
            ]);
        }
        return back();
    }
    
    public function delete($idEvaluador){
        $id_conv = session()->get('convocatoria');
        $evaluadorConvocatoria = EvaluadorConovocatoria::where('id_evaluador',$idEvaluador)
                                                ->where('id_convocatoria',$id_conv)->value('id');
        
        Tipo_evaluador::where('id_evaluador_convocatoria',$evaluadorConvocatoria)
                        ->where('id_rol_evaluador','1')->delete(); 

        if(Tipo_evaluador::where('id_evaluador_convocatoria',$evaluadorConvocatoria)->get()->isEmpty()){
                EvaluadorConovocatoria::where('id_evaluador', $idEvaluador)->delete();
        }
        return back();
    }
}
