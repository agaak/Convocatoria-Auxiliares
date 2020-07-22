<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Auxiliatura;
use App\Models\Porcentaje;
use App\Models\Tematica;

class DocenciaController extends Controller
{
    public function index() {
        $idUnidadAcademica = auth()->user()->unidad_academica_id;
        $auxiliaturas = Auxiliatura::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 2)->orderBy('id', 'ASC')->get();

        $existAux = [];

        foreach ($auxiliaturas as $auxiliatura) {
            if (Porcentaje::where('id_auxiliatura', $auxiliatura->id)->exists()) 
                array_push($existAux, true);
            else 
                array_push($existAux, false);
        }

        $tematicas = Tematica::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 2)->orderBy('id', 'ASC')->get();

        $existTem = [];

        foreach ($tematicas as $tematica) {
            if (Porcentaje::where('id_tematica', $tematica->id)->exists()) 
                array_push($existTem, true);
            else 
                array_push($existTem, false);
        }

        $areas = Area::where('id_unidad_academica', $idUnidadAcademica)
        ->where('id_tipo_convocatoria', 2)->orderBy('id', 'ASC')->get();

        $existArea = [];

        foreach ($areas as $area) {
            if (Porcentaje::where('id_area', $area->id)->exists()) 
                array_push($existArea, true);
            else 
                array_push($existArea, false);
        }

        return view('catalogo.docencia', compact('auxiliaturas', 'tematicas', 'areas', 'existAux', 'existTem', 'existArea'));
    }

    public function save() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        if (request()->has('nombre-tem-doc')) {

            request()->validate([
                'nombre-tem-doc' => 'unique:tematica,nombre,0,id,id_unidad_academica,'.$idUnidadAcademica
            ], [
                'nombre-tem-doc.unique' => 'El nombre de la temática ya existe.'
            ]);

            Tematica::create([
                'id_unidad_academica' => $idUnidadAcademica,
                'id_tipo_convocatoria' => 2,
                'nombre' => request()->input('nombre-tem-doc')
            ]);

            session()->put('dato', 2);

        } else if (request()->has('nombre-area-lab')) {

            request()->validate([
                'nombre-area-lab' => 'unique:area_calificacion,nombre,0,id,id_unidad_academica,'.$idUnidadAcademica
            ], [
                'nombre-area-lab.unique' => 'El nombre de area ya existe.'
            ]);

            Area::create([
                'id_unidad_academica' => $idUnidadAcademica,
                'id_tipo_convocatoria' => 2,
                'nombre' => request()->input('nombre-area-lab')
            ]);

            session()->put('dato', 3);

        } else {

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

            Tematica::create([
                'id_unidad_academica' => $idUnidadAcademica,
                'id_tipo_convocatoria' => 2,
                'nombre' => request()->input('nombre-auxs-lab')
            ]);

            session()->put('dato', 1);

        }


        return back();
    }
    
    public function update() {

        $idUnidadAcademica = auth()->user()->unidad_academica_id;

        
        if (request()->has('nombre-auxs-edit')) {
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

            session()->put('dato', 1);

        } else if (request()->has('nombre-area-edit')) {

            $idArea = request()->input('id-area');

            request()->validate([
                'nombre-area-edit' => 'unique:area_calificacion,nombre,'.$idArea.',id,id_unidad_academica,'.$idUnidadAcademica,
            ], [
                'nombre-area-edit.unique' => 'El nombre de area ya existe.',
            ]);

            Area::where('id', $idArea)->update([
                'nombre' => request()->input('nombre-area-edit')
            ]);

            session()->put('dato', 3);

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

            session()->put('dato', 2);

        }

        

        return back();
    }
}
