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
use App\Http\Controllers\Utils\Evaluador\MenuDina;

class VerificarReqController extends Controller
{
    public function index($idPostulante) {
        $idConv = session()->get('convocatoria');

        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        $compEval = new EvaluadorComp();
        $idEC = $compEval->getIdEvaConv();
        $roles = $compEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        $auxsTemsEval = $tipoConv === 1? $compEval->getTemsEvaluador($idEC) :$compEval->getAuxsEvaluador($idEC);


        $postulante = Postulante::where('id','=',$idPostulante)->first();
        $auxiliaturas = Postulante_auxiliatura::where('id_postulante','=',$idPostulante)
                        // ->join('postulante_conovocatoria', 'postulante_auxiliatura.id_postulante', '=', 'postulante_conovocatoria.id')
                        ->join('auxiliatura', 'postulante_auxiliatura.id', '=', 'auxiliatura.id')
                        ->join('postulante_req_aux', 'postulante_auxiliatura.id', '=', 'postulante_req_aux.id')
                        // ->where('id_convocatoria','=',$id)
                        ->orderBy('postulante_auxiliatura.id', 'ASC')
                        ->get();
        $requisitos = (new RequisitoComp)->getRequisitos($idConv);
        
        $mapVerifications = array();
        foreach ($auxiliaturas as &$auxiliatura) {
            foreach ($requisitos as $requisito) {
              $value = Postulante_req_aux::where('id_postulante_auxiliatura','=', $auxiliatura->id)
                                    ->where('id_requisito','=', $requisito->id)->first();
              $mapVerifications[$auxiliatura->id][$requisito->id] = array(                    
                        'esValido' => $value->habilitado,
                        'observacion' => $value->observacion,);
            }
        }
        // dd($mapVerifications);

        return view('evaluador.calificarRequisito', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulante','auxiliaturas','requisitos','mapVerifications'));
    }

    public function update(Request $request){
        $auxiliaturasReq = json_decode($request->input('mapverification'),true);
        
        foreach (array_keys($auxiliaturasReq) as $auxiliaturaId) {
            foreach(array_keys($auxiliaturasReq[$auxiliaturaId]) as $requisitoId){
                Postulante_req_aux::where('id_postulante_auxiliatura','=', $auxiliaturaId)
                                    ->where('id_requisito','=', $requisitoId)
                                    ->update([
                    'observacion' => $request->input('obsText'.$auxiliaturaId.$requisitoId),
                    'habilitado' => $auxiliaturasReq[$auxiliaturaId][$requisitoId]['esValido'],
                    // 'observacion' => null,
                    // 'habilitado' => null,
                ]);
            }
        }
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
                        $messageAuxiliatura = $observacionString.', '.$messageAuxiliatura;
                    }
                    $validAuxlitiatura = false;
                }
            }
            Postulante_auxiliatura::where('id', $auxiliaturaId)->update([
                'observacion' => $messageAuxiliatura,
                'habilitado' => $validAuxlitiatura,
            ]);
        }
        return redirect()->route('calificarRequisitosPost.index');;
    }
}
