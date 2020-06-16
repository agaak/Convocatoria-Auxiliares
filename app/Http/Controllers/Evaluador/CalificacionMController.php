<?php

namespace App\Http\Controllers\Evaluador;

use App\EvaluadorConocimientos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalificacionMController extends Controller
{
    public function index($id){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        return view('evaluador.calificarMeritos', compact('convs', 'id'));
    }
}
