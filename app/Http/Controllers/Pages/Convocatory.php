<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Convocatoria;
use App\Cronograma;
use App\Evento;
use App\ImportantEvents;
use App\Unidad_Academica;
use App\Requerimiento;
use Illuminate\Support\Facades\DB;
use App\Requisito;


class Convocatory extends Controller
{
    public function titleDescription(){
        $departamets=Unidad_Academica::get();
        return view('convocatory.titleDescription', compact('departamets'));
    }
    public function request(){
        return view('convocatory.request');
    }
    public function requirements(){
        return view('convocatory.requirements');
    }
    public function importantDates(){
        $importantDatesList = ImportantEvents::get();
        return view('convocatory.importantDates', compact('importantDatesList'));
    }
    public function meritRating(){
        return view('convocatory.meritRating');
    }

    public function meritRatingValid(){
        return view('convocatory.meritRating');
    }

    public function knowledgeRating(){
        return view('convocatory.knowledgeRating');
    }

    public function titleDescriptionValid(Request $request){
        $this->validate($request, [
            'titulo-conv' => 'required',
            'fecha-ini' => 'before_or_equal:fecha-fin',
            'descripcion-conv' => 'required'
        ]);
        $convocatoria= Convocatoria::create([

            'id_unidad_academica' => $request->get('departamento-ant'),
            'titulo_conv'=> $request->get('titulo-conv'),
            'descripcion_conv'=> $request->get('descripcion-conv'),
            'fecha_ini'=> $request->get('fecha-ini'),
            'fecha_fin'=>$request->get('fecha-fin')
        ]);
        $request->session()->put('convocatoria', $convocatoria->id) ;
        return view('convocatory.request');
    }
    
    public function requestValid(Request $request){
        $requerimient=Requerimiento::create([
            'id_convocatoria'=>$request->session()->get('convocatoria'),
            'nombre'=>$request->get('nombre'),
            'item'=>$request->get('item'),
            'cantidad'=>$request->get('codigo_pro'),
            'horas_mes'=>$request->get('marca'),
            'cod_aux'=>$request->get('precio')
        ]);
        return $requerimient;
    }

    public function importantDateSave(Request $request){
        DB::table('important_events')->where('id_important_events', $request->input('id-datos'))->update([
            'title_event' => $request->input('titulo-evento'),
            'place_event' => $request->input('lugar-evento'),
            'date_ini' => date("Y-m-d", strtotime($request->input('fecha-ini-evento'))),
            'date_fin' => date("Y-m-d", strtotime($request->input('fecha-fin-evento'))),
            'time_ini' => $request->input('tiempo-inicio'),
            'time_fin' => $request->input('tiempo-final')
        ]);
        return redirect()->route('importantDates');
    }

    public function requirementsValid(Request $request){
        Requisito::create([
            'id_convocatoria'=>$request->session()->get('convocatoria'), 
            'descripcion'=>$request->get('descripcion')
        ]);
        return view('convocatory.requirements');
    }

    public function importantDatesValid(Request $request){
        DB::table('important_events')->insert([
            'title_event' => $request->input('titulo-evento'),
            'place_event' => $request->input('lugar-evento'),
            'date_ini' => date("Y-m-d", strtotime($request->input('fecha-ini-evento'))),
            'date_fin' => date("Y-m-d", strtotime($request->input('fecha-fin-evento'))),
            'time_ini' => $request->input('tiempo-inicio'),
            'time_fin' => $request->input('tiempo-final')
        ]);
        return redirect()->route('importantDates');
    }

    public function importantDatesDelete(Request $request){
        DB::table('important_events')->where('id_important_events', $request->input('id-eliminar'))->delete();
        return redirect()->route('importantDates');
    }

    

}
