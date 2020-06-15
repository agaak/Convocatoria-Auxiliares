<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\EventoImportante;

class EventoComp
{   
    public function getEventos($id_conv){
        $requests=EventoImportante::where('id_convocatoria', $id_conv)
                        ->get();
        return $requests;
    }
}
