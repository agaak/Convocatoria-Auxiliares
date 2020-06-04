<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmConvocatoriaController extends Controller
{
    public function index($id)
    {   
        session()->put('convocatoria', $id) ;
        return view('admConvocatoria.admConvocatoria');
    }
}
