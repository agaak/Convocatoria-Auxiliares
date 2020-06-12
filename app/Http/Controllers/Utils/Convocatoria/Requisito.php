<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\Requisito;

class Requisito
{   
    public function getRequisitos($id_conv){
        $requests=Requisito::where('id_convocatoria', $id_conv)
                            ->orderBy('id', 'ASC')
                            ->get();
        return $requests;
    }
}
