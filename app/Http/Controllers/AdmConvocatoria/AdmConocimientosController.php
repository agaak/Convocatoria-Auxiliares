<?php

namespace App\Http\Controllers\AdmConvocatoria;

use App\EvaluadorConocimientos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdmConvocatoria\AdmConocimientosRequest;

class AdmConocimientosController extends Controller
{
    public function index()
    {
        $listaCi = EvaluadorConocimientos::select('ci')->get();
        return view('admConvocatoria.admConocimientos', compact('listaCi'));
    }

    public function store(AdmConocimientosRequest $request) {
        EvaluadorConocimientos::create([
            'ci' => $request->input('adm-cono-ci'),
            'nombre' => $request->input('adm-cono-nombre'),
            'apellido' => $request->input('adm-cono-apellidos'),
            'correo' => $request->input('adm-cono-correo')
        ]);
        return back();
    }
}
