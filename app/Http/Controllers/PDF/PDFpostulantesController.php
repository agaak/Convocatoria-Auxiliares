<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postulante;
use App\Models\PrePostulante;
use App\Models\Auxiliatura;
use App\Models\Postulante_auxiliatura;
use App\Models\Postulante_conovocatoria;
use App\Models\Convocatoria;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;

class PDFpostulantesController extends Controller
{
    public function listHabilitados()
    {
        $id_conv = session()->get('convocatoria');

        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('requerimiento.id_convocatoria',$id_conv)
        ->get();
        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];
        $listPostulantes = Postulante_auxiliatura::select('postulante_auxiliatura.*',
        'postulante.*','auxiliatura.nombre_aux')
        ->join('postulante','postulante_auxiliatura.id_postulante','=','postulante.id')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->join('auxiliatura','postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)->get();
        /* ->groupBy('postulante_auxiliatura.id','postulante.id') ->get();*/
        
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.listaHabilitados', compact('listaAux','listPostulantes','titulo_conv'));
        //return view('postulantePDF.listaHabilitados', compact('listaAux', 'listPostulantes'));
        
        return  $dompdf->download('lista-Habilitados.pdf');
    }
    public function listNotasFinales()
    {   
        $id_conv = session()->get('convocatoria');
        
        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();

        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];

        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
        'calf_fin_postulante_conoc.nota_final_conoc','calf_final_postulante_merito.nota_final_merito','postulante_auxiliatura.id_auxiliatura')
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->join('calf_fin_postulante_conoc','postulante.id','=','calf_fin_postulante_conoc.id_postulante')
        ->join('calf_final_postulante_merito','postulante.id','=','calf_final_postulante_merito.id_postulante')
        //->where('postulante_auxiliatura.habilitado', true)
        ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','calf_fin_postulante_conoc.nota_final_conoc','calf_final_postulante_merito.nota_final_merito')
        ->get();
        
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        /* return $listaPost; */
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.notasFinales', compact('listaAux','listaPost','titulo_conv'));
        //return view('postulantePDF.listaHabilitados', compact('listaAux', 'listPostulantes'));
        
        return  $dompdf->download('Notas_finales.pdf');
    }

    public function listNotasMeritos(){
        $id_conv = session()->get('convocatoria');

        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];

        $listaPost= Postulante::select('postulante.nombre','postulante.apellido','postulante.ci', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
        ->get();
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.notasMerito', compact('listaPost','titulo_conv'));
        
        return  $dompdf->download('Notas_meritos.pdf');
    }
}
