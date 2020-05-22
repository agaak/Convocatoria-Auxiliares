<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Convocatoria;
use App\Cronograma;
use App\Evento;
use App\Unidad_Academica;

class Convocatory extends Controller
{
    public function titleDescription(){
        return view('convocatory.titleDescription');
    }
    public function request(){
        return view('convocatory.request');
    }
    public function requirements(){
        return view('convocatory.requirements');
    }
    public function importantDates(){
        return view('convocatory.importantDates');
    }
    public function meritRating(){
        return view('convocatory.meritRating');
    }
    public function knowledgeRating(){
        return view('convocatory.knowledgeRating');
    }

    public function requestValid(Request $request){
        $this->validate($request, [
            'titulo-conv' => 'required',
            'fecha-ini' => 'before_or_equal:fecha-fin',
            'descripcion-conv' => 'required'
        ]);
        Convocatoria::create([
            'titulo'=> $request->get('titulo-conv'),
            'descripcion'=> $request->get('descripcion-conv')
        ]);

        return view('convocatory.request');
    }
    public function importantDatesValid(Request $request){
        $this->validate($request, [
            'fecha-ini-evento' => 'before_or_equal:fecha-fin-evento'
        ]);
        return view('convocatory.importantDates');
    }
}
