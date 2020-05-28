<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Convocatoria;
use App\Unidad_Academica;
use Illuminate\Support\Facades\DB;


class Convocatory extends Controller
{
    public function titleDescriptionGet(){
        $convo = Convocatoria::create(['id_unidad_academica' => 1 ]);
        session()->put('convocatoria', $convo->id) ;
        return redirect()->route('titleDescription');
    }

    public function titleDescription(Request $request){
        $departamets=Unidad_Academica::get();
        $convo = Convocatoria::where('id', $request->session()->get('convocatoria'))->get();
        return view('convocatory.titleDescription', compact('departamets','convo'));
    }

    public function titleDescriptionValid(Request $request){

        $this->validate($request, [
            'titulo-conv' => 'required',
            'fecha-ini' => 'before_or_equal:fecha-fin',
            'descripcion-conv' => 'required'
        ]);
        DB::table('convocatoria')->where('id', session()->get('convocatoria'))->update([
            'id_unidad_academica' => $request->input('departamento-ant'),
            'titulo_conv' => $request->input('titulo-conv'),
            'descripcion_conv' => $request->input('descripcion-conv'),
            'fecha_ini' => $request->input('fecha-ini'),
            'fecha_fin' => $request->input('fecha-fin')
        ]);

        return redirect()->route('requests');
    }
      
    
}
