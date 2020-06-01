<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmConocimientosController extends Controller
{
    public function index()
    {
        return view('admConvocatoria.admConocimientos');
    }
}
