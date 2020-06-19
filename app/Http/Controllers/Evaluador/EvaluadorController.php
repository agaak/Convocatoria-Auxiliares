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
        session()->forget('convocatoria');
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        session()->put('evaluador', $convs[0]['pivot']['id_evaluador']);
        return view('evaluador.evaluador', compact('convs')); 
    }


}
