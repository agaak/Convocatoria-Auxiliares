<?php

namespace App\Http\Controllers\Evaluador;

use Illuminate\Http\Request;
use App\EvaluadorConocimientos;
use App\Http\Controllers\Controller;

class EvaluarMController extends Controller
{
    public function index($id) {
        session()->put('convocatoria', $id) ;
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        return view('evaluador.calificacion', compact('convs', 'id'));
    }
}
