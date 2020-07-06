<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante;
class ListEnabledController extends Controller
{
    public function index() {
        $listPostulanteAux = Postulante_auxiliatura::select('postulante_auxiliatura.observacion', 'postulante_auxiliatura.id_postulante',
        'postulante_auxiliatura.habilitado','auxiliatura.nombre_aux')
        ->where('id_convocatoria',session()->get('convocatoria'))
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->get();
        $listPostulanteAux = collect($listPostulanteAux)->groupBy('id_postulante');

        $listPostulantes = Postulante::select('postulante.*')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('id_convocatoria',session()->get('convocatoria'))
        ->where('estado','publicado')
        ->orderBy('apellido','ASC')->get();

        $conv = Convocatoria::find(session()->get('convocatoria'));

        foreach($listPostulantes as $item){
            $item->nombre_aux = $listPostulanteAux[$item['id']];
        }
        return view('verConvocatoria.listaHabilitados',compact('listPostulantes', 'conv'));
    }
}
