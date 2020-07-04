<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_conovocatoria;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Http\Controllers\Utils\Evaluador\EvaluarRequisitos;

class AdmHabilitadosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador'])->except('detalles');
    }
    
    public function index()
    {   
        $id_conv = session()->get('convocatoria');

        $listPostulanteAux = Postulante_auxiliatura::select('postulante_auxiliatura.observacion', 'postulante_auxiliatura.id_postulante',
        'postulante_auxiliatura.habilitado','auxiliatura.nombre_aux')
        ->where('id_convocatoria',session()->get('convocatoria'))
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->get();
        $listPostulanteAux = collect($listPostulanteAux)->groupBy('id_postulante');

        $publicado = Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))
            ->where('estado','publicado')->get()->isNotEmpty();
        
        $entregado =  Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))
        ->where('estado','entregado')->get()->isNotEmpty();
        
        $listPostulantes = Postulante::select('postulante.*')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('id_convocatoria',session()->get('convocatoria'));
        $listPostulantes = $publicado? $listPostulantes->where('estado','publicado') : $listPostulantes->where('estado','entregado');
        $listPostulantes = $listPostulantes->orderBy('apellido','ASC')->get();
        foreach($listPostulantes as $item){
            $item->nombre_aux = $listPostulanteAux[$item['id']];
        }
        // return $listPostulantes->get();
        return view('admResultados.admHabilitados',compact('listPostulantes','publicado','entregado'));
    }

    public function publicar(){
        Postulante_conovocatoria::where('id_convocatoria', session()->get('convocatoria'))->update([
            'estado' => 'publicado',
        ]);
        return back();
    }

    public function detalles($idPostulante){
        $postulante = Postulante::where('id','=',$idPostulante)->first();
        $auxiliaturas = (new EvaluarRequisitos)->getAuxiliaturas($idPostulante);
        $requisitos = (new RequisitoComp)->getRequisitos(session()->get('convocatoria'));
        $mapVerifications = (new EvaluarRequisitos)->getMapVerification($auxiliaturas,$requisitos);
        if (auth()->check()){
            if (auth()->user()->hasRoles(['administrador'])){
                return view('admResultados.admRequisitosPost',
                compact('postulante','auxiliaturas','requisitos','mapVerifications','idPostulante'));
            } else {
                return view('verConvocatoria.requisitoPostulante',
                compact('postulante','auxiliaturas','requisitos','mapVerifications','idPostulante'));
            }
        }else{
            return view('verConvocatoria.requisitoPostulante',
                compact('postulante','auxiliaturas','requisitos','mapVerifications','idPostulante'));
        }
        
    }

}
