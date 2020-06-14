<?php

namespace App\Http\Controllers;

use App\PrePostulante;
use App\Requerimiento;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PrePostulanteController extends Controller
{
    public function exportPDF() {

        $postulante = new PrePostulante();
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
            DB::table('pre_postulante_auxiliatura')->insert([
                'id_pre_postulante' => $postulante->id,
                'id_auxiliatura' => $aux,
                'observacion' => 'ninguna'
            ]);
        }

        $auxiliaturas = Requerimiento::select('auxiliatura.*','requerimiento.id_convocatoria as id_conv')
        ->join('auxiliatura','requerimiento.id_auxiliatura','=','auxiliatura.id')
        ->groupBy('requerimiento.id_convocatoria','auxiliatura.id')->get();

        $pdf = PDF::loadView('postulantePDF.postulante', compact('postulante', 'auxiliaturas'));

        return $pdf->download('rotulo-postulante.pdf');
    }
}
