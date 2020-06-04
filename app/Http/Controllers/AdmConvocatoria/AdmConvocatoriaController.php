<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmConvocatoriaController extends Controller
{
    public function index()
    {   
        
        return view('admConvocatoria.admConvocatoria');
    }

    public function inicio($id)
    {   
        session()->put('convocatoria', $id) ;
        return view('admConvocatoria.admConvocatoria');
    }
}
