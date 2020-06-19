<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\ConvocatoriaComp;
use App\PrePostulante;
use App\Requerimiento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\PrePostulanteAuxiliatura;

class PrePostulanteController extends Controller
{
    public function exportPDF() {

        $numRandom = new ConvocatoriaComp();
        
        $postulante = new PrePostulante();
        $postulante->rotulo = $numRandom->uniqidReal();
        $postulante->id_convocatoria = request()->input('id-conv-postulante');
        $postulante->nombre = request()->input('postulante-nombre');
        $postulante->apellido = request()->input('postulante-apellidos');
        $postulante->direccion = request()->input('postulante-direccion');
        $postulante->correo = request()->input('correo-direccion');
        $postulante->cod_sis = request()->input('cod-sis');
        $postulante->telefono = request()->input('telefono');
        $postulante->ci = request()->input('ci');
        $postulante->save();
        
        foreach (request()->input('auxiliaturas') as $aux) {
            $postulante_aux = new PrePostulanteAuxiliatura();
            $postulante_aux->id_pre_postulante = $postulante->id;
            $postulante_aux->id_auxiliatura = $aux;
            $postulante_aux->save();
        }

        $auxiliaturas = PrePostulanteAuxiliatura::select('auxiliatura.*')
        ->where('id_pre_postulante',$postulante->id)
        ->join('auxiliatura','pre_postulante_auxiliatura.id_auxiliatura','=','auxiliatura.id')
        ->get();
        // return view('postulantePDF.postulante', compact('postulante', 'auxiliaturas'));
        $pdf = PDF::loadView('postulantePDF.postulante', compact('postulante', 'auxiliaturas'));

        return $pdf->download('rotulo-postulante.pdf');
    }
}
