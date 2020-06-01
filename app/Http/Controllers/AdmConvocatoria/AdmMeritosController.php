<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmMeritosController extends Controller
{
    public function index()
    {
        return view('admConvocatoria.admMeritos');
    }

}
