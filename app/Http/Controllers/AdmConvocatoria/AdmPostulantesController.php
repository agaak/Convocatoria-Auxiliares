<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Postulante;
use App\Postulante_conovocatoria;
use App\Postulante_auxiliatura;

class AdmPostulantesController extends Controller
{
    public function index()
    {
        $id_conv = session()->get('convocatoria');
        
        $listPostulantes = Postulante_auxiliatura::select('postulante_auxiliatura.*',
        'postulante.*')
        ->join('postulante','postulante_auxiliatura.id_postulante','=','postulante.id')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('id_convocatoria',$id_conv)
        ->groupBy('postulante_auxiliatura.id','postulante.id')->get();

        return $listPostulantes;//view('admConvocatoria.admPostulantes',compact('listPostulantes'));
    }

}
