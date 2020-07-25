<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\Convocatoria;
use App\Models\Postulante;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_req_aux;
use App\Models\PostuCalifConocFinal;
use App\Models\PostuCalifConoc;
use App\Models\Requerimiento;
use App\Models\Postulante_conovocatoria;
use Illuminate\Http\Request;
use App\Models\EvaluadorConocimientos;
use App\Models\EvaluadorConovocatoria;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\AdmConvocatoria\EvaluadorComp;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Http\Controllers\Utils\Evaluador\MenuDina;
use App\Http\Controllers\Utils\Evaluador\EvaluarRequisitos;

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
            return redirect()->route('calificarRequisitosPost.index')
                        ->with('revisando','Alguien esta revisando los requisitos de este postulante.');
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
        $auxsTemsEval = $compEval->getTematicsEvaluador2($idEC);


        $postulante = Postulante::where('id','=',$idPostulante)->first();
        $auxiliaturas = (new EvaluarRequisitos)->getAuxiliaturas($idPostulante);
        $requisitos = (new RequisitoComp)->getRequisitos($idConv);
        
        $mapVerifications = (new EvaluarRequisitos)->getMapVerification($auxiliaturas,$requisitos);

        return view('evaluador.calificarRequisito', compact('convs', 'roles', 'tipoConv', 'auxsTemsEval','postulante','auxiliaturas','requisitos','mapVerifications','idPostulante'));
    }

    public function update(Request $request){
        
        $auxiliaturasReq = json_decode($request->input('mapverification'),true);
        $postulanteId= request()->input('id-postulante');
        // dd($auxiliaturasReq);
        foreach (array_keys($auxiliaturasReq) as $postulanteAuxiliaturaId) {
            foreach(array_keys($auxiliaturasReq[$postulanteAuxiliaturaId]) as $requisitoId){
                Postulante_req_aux::where('id_postulante_auxiliatura','=', $postulanteAuxiliaturaId)
                                    ->where('id_requisito','=', $requisitoId)
                                    ->update([
                    'observacion' => $request->input('obsText'.$postulanteAuxiliaturaId.$requisitoId),
                    'habilitado' => $auxiliaturasReq[$postulanteAuxiliaturaId][$requisitoId]['esValido'],
                ]);
            }
        }
        
        $isErrorReq = false;
        $isErrorObs = false;
        foreach (array_keys($auxiliaturasReq) as $postulanteAuxiliaturaId) {
            $validAuxlitiatura = true;
            $messageAuxiliatura = '';

            foreach(array_keys($auxiliaturasReq[$postulanteAuxiliaturaId]) as $requisitoId){
                if($auxiliaturasReq[$postulanteAuxiliaturaId][$requisitoId]['esValido'] === null){
                    $isErrorReq = true;
                    $validAuxlitiatura = null;
                    break;
                }else if($auxiliaturasReq[$postulanteAuxiliaturaId][$requisitoId]['esValido']){
                    $validAuxlitiatura = $validAuxlitiatura && true;
                }else{
                    $observacionString =$request->input('obsText'.$postulanteAuxiliaturaId.$requisitoId);
                    if($observacionString == ''){
                        $isErrorObs = true;
                    }else{
                        $messageAuxiliatura = $observacionString.', '.$messageAuxiliatura;
                    }
                    $validAuxlitiatura = false;
                }
            }

            Postulante_auxiliatura::where('id', $postulanteAuxiliaturaId)->update([
                'observacion' => $messageAuxiliatura,
                'habilitado' => $validAuxlitiatura,
            ]);

            $aux = Postulante_auxiliatura::where('id', $postulanteAuxiliaturaId)->value('id_auxiliatura');
            if($validAuxlitiatura){
                $post_calf_conoc_fin = new PostuCalifConocFinal();
                $post_calf_conoc_fin->id_convocatoria = session()->get('convocatoria');
                $post_calf_conoc_fin->id_postulante = $postulanteId; 
                $post_calf_conoc_fin->id_auxiliatura = $aux;
                $post_calf_conoc_fin->save();

                $porcentajes = Requerimiento::select('porcentaje.*')
                ->where('requerimiento.id_convocatoria',session()->get('convocatoria'))
                ->join('porcentaje','porcentaje.id_requerimiento','=','requerimiento.id')
                ->where('porcentaje.id_auxiliatura', $aux)
                ->where('porcentaje.porcentaje','>','0')
                ->get();
                
                foreach($porcentajes as $por){
                    $post_calf_conoc = new PostuCalifConoc();
                    $post_calf_conoc->id_postulante = $postulanteId;
                    $post_calf_conoc->id_porcentaje = $por->id;
                    $post_calf_conoc->id_calf_final = $post_calf_conoc_fin->id;
                    $post_calf_conoc->save();
                }
            }else{
                PostuCalifConocFinal::where('id_auxiliatura',$aux)
                ->where('id_postulante',$postulanteId)->delete(); 
            }
        }

        Postulante_conovocatoria::where('id_postulante', $postulanteId)->update([
            'calificando_requisito' => false,
        ]);
        if($isErrorReq){
            return back()->with('errorCalificarReq', 'Hay requisitos no calificados.');
        } else if($isErrorObs){
            return back()->with('errorCalificarReq', 'Todos los campos observacion deben estar llenados..');

        }
        return redirect()->route('calificarRequisitosPost.index');
    }
}
