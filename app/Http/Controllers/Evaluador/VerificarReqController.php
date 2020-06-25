<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\Convocatoria;
use App\Models\Postulante;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_req_aux;
use App\Models\Postulante_conovocatoria;
use Illuminate\Http\Request;
use App\Models\EvaluadorConocimientos;
use App\Models\EvaluadorConovocatoria;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;

class VerificarReqController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index($idPostulante) {
        $idConv = session()->get('convocatoria');

        $existe = Postulante_conovocatoria::where('id_postulante',$idPostulante)
            ->value('calificando_requisito');
        if($existe){
            return redirect()->route('calificarRequisitosPost.index');
        }
        session()->put('id-pos',$idPostulante);
        Postulante_conovocatoria::where('id_postulante', $idPostulante)->update([
            'calificando_requisito' => true,
        ]);
        $menu = new MenuDina();
        $convs = $menu->getConvs(); 
        $compEval = new EvaluadorComp();
        $idEC = $compEval->getIdEvaConv();
        $roles = $compEval->getRolesEvaluador($idEC);
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        $auxsTemsEval = $tipoConv === 1? $compEval->getTemsEvaluador($idEC) :$compEval->getAuxsEvaluador($idEC);


        $postulante = Postulante::where('id','=',$idPostulante)->first();
        $auxiliaturas = Postulante_auxiliatura::where('id_postulante','=',$idPostulante)
                        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
                        ->join('postulante_req_aux', 'postulante_auxiliatura.id', '=', 'postulante_req_aux.id')
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

        return view('evaluador.calificarRequisito', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulante','auxiliaturas','requisitos','mapVerifications','idPostulante'));
    }

    public function update(Request $request){
        
        $auxiliaturasReq = json_decode($request->input('mapverification'),true);
        //return $request;
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
                    Postulante_conovocatoria::where('id_postulante', request()->input('id-postulante'))->update([
                        'calificando_requisito' => false,
                    ]);
                    return back()->with('errorCalificarReq', 'Hay requisitos no calificados.');
                    //error de no seleccionar como tru o false el requisito
                }else if($auxiliaturasReq[$auxiliaturaId][$requisitoId]['esValido']){
                    $validAuxlitiatura = $validAuxlitiatura && true;
                }else{
                    $observacionString =$request->input('obsText'.$auxiliaturaId.$requisitoId);
                    if($observacionString == ''){
                        // $validAuxlitiatura = false;
                        Postulante_conovocatoria::where('id_postulante', request()->input('id-postulante'))->update([
                            'calificando_requisito' => false,
                        ]);
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
        Postulante_conovocatoria::where('id_postulante', request()->input('id-postulante'))->update([
            'calificando_requisito' => false,
        ]);
        return redirect()->route('calificarRequisitosPost.index');
    }
}
