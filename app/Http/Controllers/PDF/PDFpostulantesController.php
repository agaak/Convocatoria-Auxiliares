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
use App\Models\Tematica;
use App\Models\Area;
use App\Http\Controllers\Utils\Evaluador\PostulanteComp;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;

class PDFpostulantesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador,evaluador']);
    }
    public function listHabilitados(){
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
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->orderBy('postulante.apellido','ASC')
        ->get();
        /* ->groupBy('postulante_auxiliatura.id','postulante.id') ->get();*/
        
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.listaHabilitados', compact('listaAux','listPostulantes','titulo_conv'));
        //return view('postulantePDF.listaHabilitados', compact('listaAux', 'listPostulantes'));
        
        return  $dompdf->download('lista-Habilitados.pdf');
    }

    public function listNotasFinales(){   
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
        ->where('postulante_auxiliatura.habilitado', true)
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

        $listaPost= Postulante::select('postulante.nombre', 'postulante.apellido', 'postulante.ci', 'postulante.id', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->where('postulante_auxiliatura.habilitado',true)
        ->orderBy('postulante.apellido','ASC')
        ->get() ;
        $listaPost = collect($listaPost)->unique('id'); 
        
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.notasMerito', compact('listaPost','titulo_conv'));
        return  $dompdf->download('Notas_meritos.pdf');
    }

    public function asignacionItems(){
        $id_conv = session()->get('convocatoria'); 
        
        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];

        $listaAux = Auxiliatura::select('auxiliatura.nombre_aux','auxiliatura.id')
        ->join('requerimiento','auxiliatura.id','=','requerimiento.id_auxiliatura')
        ->where('id_convocatoria',$id_conv)
        ->get();
        $tipoConv= Convocatoria::select('tipo_convocatoria.id')
                    ->join('tipo_convocatoria', 'tipo_convocatoria.id', '=', 'convocatoria.id_tipo_convocatoria')
                    ->where('convocatoria.id',$id_conv)
                    ->get();
        $listaPost = Postulante::select('postulante.nombre','postulante.apellido','postulante.ci','postulante.id',
        'postulante_auxiliatura.calificacion','postulante_auxiliatura.item','postulante_auxiliatura.id_auxiliatura')
        ->join('postulante_auxiliatura','postulante.id','=','postulante_auxiliatura.id_postulante')
        ->join('postulante_conovocatoria','postulante.id','=','postulante_conovocatoria.id_postulante')
        ->where('postulante_conovocatoria.id_convocatoria',$id_conv)
        ->where('postulante_auxiliatura.habilitado', true)
        ->join('calf_fin_postulante_conoc', 'calf_fin_postulante_conoc.id_postulante', '=', 'postulante.id')
        ->where('calf_fin_postulante_conoc.id_convocatoria', $id_conv)
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', $id_conv)
        ->whereNotNull('postulante_auxiliatura.calificacion')
        ->where('postulante_auxiliatura.calificacion', '>=', 51)
        ->orWhere('postulante_auxiliatura.item', '!=', null)
        ->groupby('postulante_auxiliatura.id_auxiliatura','postulante.id','postulante_auxiliatura.calificacion','postulante_auxiliatura.item')
        ->orderBy('postulante_auxiliatura.calificacion', 'DESC')
        ->get();
        $listaPost = collect($listaPost)->groupBy('id_auxiliatura');
        /* return $listaPost; */
        
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.listaGanadores', compact('listaAux','listaPost','titulo_conv'));
        return  $dompdf->download('Asignacion_Auxiliaturas.pdf');
    }

    public function listNotasTematica($id_tem,$nom_tem){
        // return $id_tem.'-'.$nom_tem;
        $id_conv = session()->get('convocatoria');
        $tipoConv = Convocatoria::where('id', session()->get('convocatoria'))->value('id_tipo_convocatoria');
        
        $nom_tematica = Tematica::where('id',$id_tem)->value('nombre').' - '.Area::where('id',$nom_tem)->value('nombre');
        $titulo_conv= Convocatoria::select('convocatoria.titulo')
        ->where('convocatoria.id',$id_conv)->get();
        $titulo_conv=$titulo_conv[0]['titulo'];

        $compPost = new PostulanteComp();
        $postulantes = $compPost->getPostulantesByTem($id_tem,$nom_tem); 
       /* return $postulantes;  */
        $dompdf = new Dompdf();
        $dompdf->set_paper('letter', 'portrait');
        $dompdf = PDF::loadView('postulantePDF.listaTematica', compact('nom_tematica','postulantes','titulo_conv'));
        //return view('postulantePDF.listaHabilitados', compact('listaAux', 'listPostulantes'));
        
        return  $dompdf->download($nom_tematica.'.pdf');
        //return $nom_tematica;
    }

}
