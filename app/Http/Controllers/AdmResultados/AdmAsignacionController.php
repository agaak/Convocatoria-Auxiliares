<?php

namespace App\Http\Controllers\AdmResultados;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auxiliatura;
use App\Models\Postulante;

class AdmAsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:administrador']);
    }
    
    public function index()
    {   
        $id_conv = session()->get('convocatoria');

        return view('admResultados.admAsignaciones');
    }

}
