<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Tematica;

class DocenciaController extends Controller
{
    public function index() {
        $idUnidadAcademica = auth()->user()->unidad_academica_id;
        $auxiliaturas = Auxiliatura::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 2)->orderBy('id', 'ASC')->get();

        $tematicas = Tematica::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 2)->orderBy('id', 'ASC')->get();

        return view('catalogo.docencia', compact('auxiliaturas', 'tematicas'));
    }

    public function save() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        request()->validate([
            'nombre-auxs-lab' => 'unique:auxiliatura,nombre_aux,0,id,id_unidad_academica,'.$idUnidadAcademica,
            'codigo-auxs-lab' => 'unique:auxiliatura,cod_aux,0,id,id_unidad_academica,'.$idUnidadAcademica
        ], [
            'nombre-auxs-lab.unique' => 'El nombre de auxiliatura ya existe.',
            'codigo-auxs-lab.unique' => 'El código de auxiliatura ya existe.'
        ]);

        Auxiliatura::create([
            'id_unidad_academica' => $idUnidadAcademica,
            'id_tipo_convocatoria' => 2,
            'nombre_aux' => request()->input('nombre-auxs-lab'),
            'cod_aux' => request()->input('codigo-auxs-lab')
        ]);

        return back();
    }
    
    public function update() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        $idAuxiliatura = request()->input('id-auxiliatura');

        request()->validate([
            'nombre-auxs-edit' => 'unique:auxiliatura,nombre_aux,'.$idAuxiliatura.',id,id_unidad_academica,'.$idUnidadAcademica,
            'codigo-auxs-edit' => 'unique:auxiliatura,cod_aux,'.$idAuxiliatura.',id,id_unidad_academica,'.$idUnidadAcademica
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
}
