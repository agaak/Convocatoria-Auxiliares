<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotasAuxiliaturaController extends Controller
{
    public function index() {
        return view('verConvocatoria.notasConocimientoA');
    }
}
