<?php

namespace App\Http\Controllers\Evaluador;

use App\Convocatoria;
use App\EvaluadorConocimientos;
use App\Http\Controllers\Controller;
use App\EvaluadorConovocatoria;
use Illuminate\Http\Request;

class EvaluadorController extends Controller
{
    public function index() {
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        return view('evaluador.evaluador', compact('convs'));
    }
}
