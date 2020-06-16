<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use Illuminate\Support\Facades\DB;

class RequisitoComp
{   
    public function getRequisitos($id_conv){
        $requests=DB::table('requisito')->where('id_convocatoria', $id_conv)
                            ->orderBy('id', 'ASC')
                            ->get();
        return $requests;
    }
}
