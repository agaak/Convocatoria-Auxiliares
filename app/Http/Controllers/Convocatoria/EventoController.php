<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\EventosImportantes;

class EventoController extends Controller
{
    public function importantDateSave(Request $request){
        DB::table('eventos_importantes')->where('id_eventos_importantes', $request->input('id-datos'))->update([
            'titulo_evento' => $request->input('titulo-evento'),
            'lugar_evento' => $request->input('lugar-evento'),
            'fecha_inicio' => date("Y-m-d", strtotime($request->input('fecha-ini-evento'))),
            'fecha_final' => date("Y-m-d", strtotime($request->input('fecha-fin-evento'))),
            'hora_inicio' => $request->input('tiempo-inicio'),
            'hora_final' => $request->input('tiempo-final')
        ]);
        return back();
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
        return back();
    }

    public function importantDatesDelete($id){
        DB::table('eventos_importantes')->where('id_eventos_importantes', $id)->delete();
        return back();
    }

    public function importantDates(Request $request){
        // $importantDatesList = EventosImportantes::orderBy('id_eventos_importantes', 'ASC')->get();
        $importantDatesList=DB::table('evento')->
            where('id_convocatoria', $request->session()->get('convocatoria'))
            ->get();
        return view('convocatory.eventos', compact('importantDatesList'));
    }
}
