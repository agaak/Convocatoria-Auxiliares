<?php

namespace App\Http\Controllers\Evaluador;

use Illuminate\Http\Request;
use App\EvaluadorConocimientos;
use App\Http\Controllers\Controller;

class CalificarMeritoController extends Controller
{
    public function index() {
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        return view('evaluador.calificarMerito', compact('convs'));
    }
}
