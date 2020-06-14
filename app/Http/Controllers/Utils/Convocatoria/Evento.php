<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\EventoImportante;

class Evento
{   
    public function getEventos($id_conv){
        $requests=EventoImportante::where('id_convocatoria', $id_conv)
                        ->get();
        return $requests;
    }
}
