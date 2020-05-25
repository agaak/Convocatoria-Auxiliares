<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Convocatoria;
use App\Cronograma;
use App\Evento;
use App\EventosImportantes;
use App\Merito;
use App\Unidad_Academica;
use App\Requerimiento;
use Illuminate\Support\Facades\DB;
use App\Requisito;
use App\Tematica;


class Convocatory extends Controller
{
    public function titleDescription(){
        $departamets=Unidad_Academica::get();
        return view('convocatory.titleDescription', compact('departamets'));
    }
    public function requests(){
        $requests=Requerimiento::get();

        return view('convocatory.requests', compact('requests')); //
    }
    public function requirements(){
        return view('convocatory.requirements');
    }
    public function importantDates(){
        $importantDatesList = EventosImportantes::get();
        return view('convocatory.importantDates', compact('importantDatesList'));
    }
    public function meritRating(){
        $meritList = DB::table('merito')->get();

        $llenarLista = [];
        $listaInicial = [];
        foreach ($meritList as $value) {
            $listaInicial = [];
            array_push($listaInicial, $value->id_sub_merito);
            array_push($listaInicial, $value->descripcion);
            array_push($listaInicial, $value->porcentaje);
            array_push($listaInicial, $value->id_merito);
            $llenarLista[$value->id_merito] = $listaInicial;
        }

        function buscarPerteneciente($original, $identificador, $arreglo, $caracteres, $cadena) {
            $contador = 1;
            $cadenaTempral = "";
            foreach ($original as $key => $value) {
                if ($value[0] !== null) {
                    if($value[0] === $identificador) {
                        $cadenaTemporal = $cadena.$contador;
                        $value[1] = chr($caracteres).$cadenaTemporal.') '.$value[1];
                        array_push($arreglo, $value);
                        $arreglo = buscarPerteneciente($original ,$key, $arreglo, $caracteres, $cadenaTemporal.'.');
                        $contador++;
                    }
                }
            }
            return $arreglo;
        }

        $listaOrdenada = [];
        $caracteres = 321;
        foreach ($llenarLista as $key => $value) {
            if ($value[0] === null) {
                $value[1] = chr($caracteres).') '.$value[1];
                array_push($listaOrdenada, $value);
                $listaOrdenada = buscarPerteneciente($llenarLista, $key, $listaOrdenada, $caracteres, '.');
                $caracteres++;
            }
        }

        return view('convocatory.meritRating', compact('listaOrdenada'));
    }

    

    public function meritRatingValid(Request $request){
        if ($request->has('merito-o-submerito')) {

        } else {
            DB::table('merito')->insert([
                'descripcion' => $request->input('descripcion-merito'),
                'porcentaje' => $request->input('porcentaje-merito')
            ]);
        }
        return redirect()->route('meritRating');
    }

    public function meritRatingDelete($id){
        DB::table('merito')->where('id_merito', $id)->delete();
        return redirect()->route('meritRating');
    }

    public function meritRatingUpdate(Request $request){
        if ($request->input('_method') === 'PUT') {
            DB::table('merito')->where('id_merito', $request->input('id-merito'))->update([
                'descripcion' => $request->input('descripcion-merito'),
                'porcentaje' => $request->input('porcentaje-merito')
            ]);
        } else {
            
        }
        
        return redirect()->route('meritRating');
    }

    public function knowledgeRating(){
        $tematics=Tematica::get();
        $requests=Requerimiento::get();
        return view('convocatory.knowledgeRating', compact('tematics', 'requests'));
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
        $requests=Requerimiento::get();
        return view('convocatory.requests', compact('requests'));
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
        $requests=Requerimiento::get();
        return view('convocatory.requests', compact('requests'));
    }

    public function requestUpdate(Request $request){
        DB::table('requerimiento')->where('id', $request->input('id-request'))->update([
            'nombre' => $request->input('nombre-request'),
            'item' => $request->input('item-request'),
            'horas_mes' => $request->input('horas_mes-request'),
            'cantidad' => $request->input('cantidad-request'),
            'cod_aux' => $request->input('cod_aux-request')
        ]);
        return redirect()->route('requests');
    }

    public function importantDateSave(Request $request){
        DB::table('eventos_importantes')->where('id_eventos_importantes', $request->input('id-datos'))->update([
            'titulo_evento' => $request->input('titulo-evento'),
            'lugar_evento' => $request->input('lugar-evento'),
            'fecha_inicio' => date("Y-m-d", strtotime($request->input('fecha-ini-evento'))),
            'fecha_final' => date("Y-m-d", strtotime($request->input('fecha-fin-evento'))),
            'hora_inicio' => $request->input('tiempo-inicio'),
            'hora_final' => $request->input('tiempo-final')
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
        DB::table('eventos_importantes')->insert([
            'titulo_evento' => $request->input('titulo-evento'),
            'lugar_evento' => $request->input('lugar-evento'),
            'fecha_inicio' => date("Y-m-d", strtotime($request->input('fecha-ini-evento'))),
            'fecha_final' => date("Y-m-d", strtotime($request->input('fecha-fin-evento'))),
            'hora_inicio' => $request->input('tiempo-inicio'),
            'hora_final' => $request->input('tiempo-final')
        ]);
        return redirect()->route('importantDates');
    }

    public function importantDatesDelete($id){
        DB::table('eventos_importantes')->where('id_eventos_importantes', $id)->delete();
        return redirect()->route('importantDates');
    }

    public function requestDelete($id){
        DB::table('requerimiento')->where('id', $id)->delete();
        return redirect()->route('requests');
    }
    
    public function knowledgeRatingTematicValid(Request $request){
        DB::table('tematica')->insert([
            'nombre' => $request->input('nombre'),
            'porcentaje' => $request->input('porcentaje')
        ]);
        return redirect()->route('knowledgeRating');
    }
    


    public function knowledgeRatingTematicDelete($id){
        DB::table('tematica')->where('id', $id)->delete();
        return redirect()->route('knowledgeRating');
    }
}
