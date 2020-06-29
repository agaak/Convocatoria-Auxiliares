<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Requerimiento;

class LaboratorioController extends Controller
{
    public function index() {

        $auxiliaturas = Auxiliatura::where('id_unidad_academica', auth()->user()->unidad_academica_id)->orderBy('id', 'ASC')->get();

        return view('catalogo.laboratorio', compact('auxiliaturas'));
    }

    public function save() {
        request()->validate([
            'nombre-auxs-lab' => 'unique:auxiliatura,nombre_aux',
            'codigo-auxs-lab' => 'unique:auxiliatura,cod_aux'
        ], [
            'nombre-auxs-lab.unique' => 'El nombre de auxiliatura ya existe.',
            'codigo-auxs-lab.unique' => 'El código de auxiliatura ya existe.'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => auth()->user()->unidad_academica_id,
            'id_tipo_convocatoria' => 1,
            'nombre_aux' => request()->input('nombre-auxs-lab'),
            'cod_aux' => request()->input('codigo-auxs-lab')
        ]);
        
        return back();
    }

    public function delete($id) {
        $requerimientos = Requerimiento::get();

        foreach($requerimientos as $requerimiento) {
            if ($requerimiento->id_auxiliatura == $id) {
                request()->validate([
                    'existe' => 'required'
                ], [
                    'existe.required' => 'La Auxiliatura no puede ser eliminada, porque esta esta usando en una Convocatoria.'
                ]);
            }
        }

        Auxiliatura::where('id', $id)->delete();
        return back();
    }
}
