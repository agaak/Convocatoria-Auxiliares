<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmConvocatoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador,receptor documentos']);
    }
    
    public function index()
    {   
        
        return view('admConvocatoria.admConvocatoria');
    }

    public function inicio($id)
    {   
        session()->put('convocatoria', $id) ;
        if(auth()->user()->hasRoles(['receptor documentos'])){ 
            return redirect()->route('admPostulantes');
        } else {
            return redirect()->route('admConocimientos');
        }
    }
}
