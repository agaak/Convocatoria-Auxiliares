<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use Illuminate\Support\Facades\DB;

class Documento
{   
    public function getDocumentos($id_conv){
        $requests=DB::table('documento')->where('id_convocatoria', $id_conv)
                            ->orderBy('id', 'ASC')
                            ->get();
        return $requests;
    }
}
