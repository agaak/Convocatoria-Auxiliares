<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use App\Postulante;
use App\Postulante_auxiliatura;
use App\Postulante_req_aux;
use Illuminate\Http\Request;
use App\EvaluadorConocimientos;
use App\EvaluadorConovocatoria;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;

class VerificarReqController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index($idPostulante) {
        $idConv = session()->get('convocatoria');
        // $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        // foreach ($convs as $conv) {
        //     if ($conv->id == $idConv)
        //         $pivot = $conv->pivot;
        // }
        // $idEC = EvaluadorConovocatoria::where('id_convocatoria', $pivot['id_convocatoria'])->
        //                                 where('id_evaluador', $pivot['id_evaluador'])->value('id');
        // $rolsEval = new EvaluadorComp();
        // $roles = $rolsEval->getRolesEvaluador($idEC);
        // $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        // $auxsTemsEval = $tipoConv === 1? $rolsEval->getTemsEvaluador($idEC) :$rolsEval->getAuxsEvaluador($idEC);
        
        $postulante = Postulante::where('id','=',$idPostulante)->first();
        $auxiliaturas = Postulante_auxiliatura::where('id_postulante','=',$idPostulante)
                        ->join('auxiliatura', 'postulante_auxiliatura.id', '=', 'auxiliatura.id')
                        ->join('postulante_req_aux', 'postulante_auxiliatura.id', '=', 'postulante_req_aux.id')
                        ->get();
        $requisitos = (new RequisitoComp)->getRequisitos($idConv);

        $mapVerifications = array();
        foreach ($auxiliaturas as &$auxiliatura) {
            foreach ($requisitos as $requisito) {
              $mapVerifications[$auxiliatura->id][$requisito->id] = array(                    
                        'esValido' => $auxiliatura->habilitado,
                        'observacion' => $auxiliatura->observacion,);
            }
        }
        return view('evaluador.calificarRequisito', compact('postulante','auxiliaturas','requisitos','mapVerifications'));
    }

    public function update(Request $request){
        $auxiliaturasReq = json_decode($request->input('mapverification'),true);
        foreach (array_keys($auxiliaturasReq) as $auxiliaturaId) {
            foreach(array_keys($auxiliaturasReq[$auxiliaturaId]) as $requisitoId){
                Postulante_req_aux::where('id_postulante_auxiliatura', $auxiliaturaId)
                                    ->where('id_requisito', $requisitoId)
                                    ->update([
                    'observacion' => $request->input('obsText'.$auxiliaturaId.$requisitoId),
                    'habilitado' => $auxiliaturasReq[$auxiliaturaId][$requisitoId]['esValido'],
                ]);
            }
        }

        // $this->validate($request, [
        //     'name' => 'string|min:30|max:60',
        //     'email' => 'unique:users,email|required'
        // ], [
        //     'name.*' => 'Nombre invalido',
        //     'email.required' => 'El correo electronico es un campo obligatorio'
        // ]);
        $validAxiliaturas = array();
        foreach (array_keys($auxiliaturasReq) as $auxiliaturaId) {
            $validAuxlitiatura = true;
            $messageAuxiliatura = '';
            foreach(array_keys($auxiliaturasReq[$auxiliaturaId]) as $requisitoId){
                if($auxiliaturasReq[$auxiliaturaId][$requisitoId]['esValido'] ===null){
                    // $validAuxlitiatura = false;
                    return back()->with('errorCalificarReq', 'Hay requisitos no calificados.');
                    //error de no seleccionar como tru o false el requisito
                }else if($auxiliaturasReq[$auxiliaturaId][$requisitoId]['esValido']){
                    $validAuxlitiatura = $validAuxlitiatura && true;
                }else{
                    $observacionString =$request->input('obsText'.$auxiliaturaId.$requisitoId);
                    if($observacionString == ''){
                        // $validAuxlitiatura = false;
                        return back()->with('errorCalificarReq', 'Todos los campos observacion deben estar llenados..');
                    }else{
                        $messageAuxiliatura = $messageAuxiliatura.', '.$observacionString;
                    }
                    $validAuxlitiatura = false;
                }
            }
            // dd($requisitos);
            Postulante_auxiliatura::where('id', $auxiliaturaId)->update([
                'observacion' => $messageAuxiliatura,
                'habilitado' => $validAuxlitiatura,
            ]);
        }
        return redirect()->route('documentos');;
    }
}
