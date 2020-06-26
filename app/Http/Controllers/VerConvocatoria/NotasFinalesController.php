<?php

namespace App\Http\Controllers\VerConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotasFinalesController extends Controller
{
    public function index() {
        return view('verConvocatoria.notasFinales');
    }
}
