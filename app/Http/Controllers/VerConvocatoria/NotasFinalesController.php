<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Convocatoria;

class NotasFinalesController extends Controller
{
    public function index() {
        $conv = Convocatoria::find(session()->get('convocatoria'));
        return view('verConvocatoria.notasFinales', compact('conv'));
    }
}
