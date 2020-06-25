<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postulante;
use App\Models\PrePostulante;
use App\Models\Auxiliatura;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_conovocatoria;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;

class PDFpostulantesController extends Controller
{
    public function listHabilitados()
    {
        $id_conv = session()->get('convocatoria');

        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','convocatoria.titulo')
        ->join ('convocatoria','auxiliatura.id_tipo_convocatoria','=','convocatoria.id_tipo_convocatoria')
        -> where ('convocatoria.id',$id_conv)->get();
                /* 
        SELECT auxiliatura.nombre_aux		
        FROM auxiliatura
        JOIN convocatoria ON auxiliatura.id_tipo_convocatoria=convocatoria.id_tipo_convocatoria
        WHERE auxiliatura.id_tipo_convocatoria=1; */

        $listPostulantes = Postulante_auxiliatura::select('postulante_auxiliatura.*',
        'postulante.*','auxiliatura.nombre_aux')
        ->join('postulante','postulante_auxiliatura.id_postulante','=','postulante.id')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->where('id_convocatoria',$id_conv)->get();
        /* ->groupBy('postulante_auxiliatura.id','postulante.id') ->get();*/
        //return $listaAux;
        $dompdf = new Dompdf();
        $dompdf->set_paper('legal', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.listaHabilitados', compact('listaAux','listPostulantes'));
        //return view('postulantePDF.listaHabilitados', compact('listaAux', 'listPostulantes'));
        
        return  $dompdf->download('lista-Habilitados.pdf');
    }
}
