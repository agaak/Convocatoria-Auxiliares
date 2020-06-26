<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotasTematicaController extends Controller
{
    public function index() {
        return view('verConvocatoria.notasConocimientoT');
    }
}
