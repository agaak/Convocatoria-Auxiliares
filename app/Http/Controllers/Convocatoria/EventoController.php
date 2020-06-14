<?php

namespace App\Http\Controllers\Convocatoria;

use App\Convocatoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\EventoCreateRequest;
use App\Http\Requests\Convocatoria\EventoUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utils\Convocatoria\Evento;
use App\EventoImportante;

class EventoController extends Controller
{
    
    public function importantDates(Request $request){
        $convActual = $request->session()->get('convocatoria');
        $importantDatesList = (new Evento)->getEventos($convActual);
        $convocatoria = Convocatoria::select('fecha_inicio','fecha_final')
                                        ->where('id',$convActual)->get();
        return view('convocatory.eventos', compact('importantDatesList','convocatoria'));
    }

    public function importantDateSave(EventoCreateRequest $request){
        DB::table('evento')->insert([
            'id_convocatoria' => $request->session()->get('convocatoria'),
            'titulo_evento' => $request->input('titulo-evento'),
            'lugar_evento' => $request->input('lugar-evento'),
            'fecha_inicio' => date("Y-m-d\TH:i", strtotime($request->input('fecha-ini-evento'))),
            'fecha_final' => date("Y-m-d\TH:i", strtotime($request->input('fecha-fin-evento'))),
        ]);
        return back();
    }

    public function importantDatesUpdate(EventoUpdateRequest $request){
        DB::table('evento')->where('id', $request->input('id-datos-edit'))->update([
            'titulo_evento' => $request->input('titulo-evento-edit'),
            'lugar_evento' => $request->input('lugar-evento-edit'),
            'fecha_inicio' => date("Y-m-d\TH:i", strtotime($request->input('fecha-ini-evento-edit'))),
            'fecha_final' => date("Y-m-d\TH:i", strtotime($request->input('fecha-fin-evento-edit'))),
        ]);
        return back();
    }

    public function importantDatesDelete($id){
        DB::table('evento')->where('id', $id)->delete();
        return back();
    }

}
