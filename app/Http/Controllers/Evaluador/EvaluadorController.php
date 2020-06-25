<?php

namespace App\Http\Controllers\Evaluador;

use App\Models\EvaluadorConocimientos;
use App\Http\Controllers\Controller;
use App\Models\Tipo;

class EvaluadorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:evaluador']);
    }
    
    public function index() {

        session()->forget('convocatoria');
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        session()->put('evaluador', $convs[0]['pivot']['id_evaluador']);
        return view('evaluador.evaluador', compact('convs')); 
    }
}
