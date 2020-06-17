<?php

namespace App\Http\Controllers\Evaluador;

use App\EvaluadorConocimientos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalificarController extends Controller
{
    public function index(){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        return view('evaluador.calificar', compact('convs'));
    }
}
