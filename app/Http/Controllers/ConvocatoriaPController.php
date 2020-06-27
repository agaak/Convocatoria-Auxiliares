<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvocatoriaPController extends Controller
{
    public function index() {
        return view('convocatoriasPasadas');
    }
}
