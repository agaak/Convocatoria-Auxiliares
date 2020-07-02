<?php

namespace App\Http\Controllers\AdmConvocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;

class AdmAvisosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles:secretaria']);
    }
    
    public function index()
    {
        return view('admConvocatoria.admAvisos');
    }


}
