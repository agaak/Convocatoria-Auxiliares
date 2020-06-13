<?php

namespace App\Http\Controllers;

use App\PrePostulante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        return request();
    }
}
