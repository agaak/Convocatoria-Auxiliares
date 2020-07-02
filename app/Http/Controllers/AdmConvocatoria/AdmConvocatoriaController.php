<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmConvocatoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador,secretaria']);
    }
    
    public function index()
    {   
        
        return view('admConvocatoria.admConvocatoria');
    }

    public function inicio($id)
    {   
        session()->put('convocatoria', $id) ;
        if(auth()->user()->hasRoles(['secretaria'])){ 
            return redirect()->route('admConocimientos');
        } else {
            return redirect()->route('admHabilitados');
        }
    }
}
