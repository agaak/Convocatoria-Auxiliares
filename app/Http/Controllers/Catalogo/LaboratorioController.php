<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Requerimiento;
use App\Models\Tematica;

class LaboratorioController extends Controller
{
    public function index() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        $auxiliaturas = Auxiliatura::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 1)->orderBy('id', 'ASC')->get();

        $tematicas = Tematica::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 1)->orderBy('id', 'ASC')->get();

        return view('catalogo.laboratorio', compact('auxiliaturas', 'tematicas'));
    }

    public function save() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        if (request()->has('nombre-auxs-lab')) {

            request()->validate([
                'nombre-auxs-lab' => 'unique:auxiliatura,nombre_aux',
                'codigo-auxs-lab' => 'unique:auxiliatura,cod_aux'
            ], [
                'nombre-auxs-lab.unique' => 'El nombre de auxiliatura ya existe.',
                'codigo-auxs-lab.unique' => 'El código de auxiliatura ya existe.'
            ]);
    
            Auxiliatura::create([
                'id_unidad_academica' => $idUnidadAcademica,
                'id_tipo_convocatoria' => 1,
                'nombre_aux' => request()->input('nombre-auxs-lab'),
                'cod_aux' => request()->input('codigo-auxs-lab')
            ]);

        } else {

            request()->validate([
                'nombre-tem-lab' => 'unique:tematica,nombre,0,id,id_unidad_academica,'.$idUnidadAcademica
            ], [
                'nombre-tem-lab.unique' => 'El nombre de la temática ya existe.'
            ]);

            Tematica::create([
                'id_unidad_academica' => $idUnidadAcademica,
                'id_tipo_convocatoria' => 1,
                'nombre' => request()->input('nombre-tem-lab')
            ]);

        }
        
        return back();
    }

    public function update() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        if (request()->has('nombre-auxs-edit')) {

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

        } else {

            $idTematica = request()->input('id-tematica');

            request()->validate([
                'nombre-tem-edit' => 'unique:tematica,nombre,'.$idTematica.',id,id_unidad_academica,'.$idUnidadAcademica,
            ], [
                'nombre-tem-edit.unique' => 'El nombre de la temática ya existe.',
            ]);

            Tematica::where('id', $idTematica)->update([
                'nombre' => request()->input('nombre-tem-edit')
            ]);

        }

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
