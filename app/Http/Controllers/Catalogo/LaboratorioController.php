<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Requerimiento;

class LaboratorioController extends Controller
{
    public function index() {

        $auxiliaturas = Auxiliatura::where('id_unidad_academica', auth()->user()->unidad_academica_id)
        ->where('id_tipo_convocatoria', 1)->orderBy('id', 'ASC')->get();

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

    public function update() {
        $idAuxiliatura = request()->input('id-auxiliatura');

        request()->validate([
            'nombre-auxs-edit' => 'unique:auxiliatura,nombre_aux,'.$idAuxiliatura,
            'codigo-auxs-edit' => 'unique:auxiliatura,cod_aux,'.$idAuxiliatura
        ], [
            'nombre-auxs-edit.unique' => 'El nombre de auxiliatura ya existe.',
            'codigo-auxs-edit.unique' => 'El código de auxiliatura ya existe.'
        ]);

        Auxiliatura::where('id', $idAuxiliatura)->update([
            'nombre_aux' => request()->input('nombre-auxs-edit'),
            'cod_aux' => request()->input('codigo-auxs-edit')
        ]);

        return back();
    }

    public function enable($id) {
        
        if (Auxiliatura::find($id)->habilitado) {
            Auxiliatura::where('id', $id)->update([
                'habilitado' => false
            ]);
        } else {
            Auxiliatura::where('id', $id)->update([
                'habilitado' => true
            ]);
        }
        
        return back();
    }
}
