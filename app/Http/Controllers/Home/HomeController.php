<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aviso;

class HomeController extends Controller
{
    // public function __construct(){
    //     $this->middleware(['auth', 'roles:secretaria']);
    // }
    
    public function index(){
        $listAvisos = Aviso::join('convocatoria','aviso.id_convocatoria','=','convocatoria.id')
                              ->join('unidad_academica','convocatoria.id_unidad_academica','=','unidad_academica.id')
                              ->get();
        if(count($listAvisos)>3){
            $listAvisos = $listAvisos->chunk(3)[0];
        }             
        // dd($listAvisos);                 
        return view('home',compact('listAvisos'));
    }
}
