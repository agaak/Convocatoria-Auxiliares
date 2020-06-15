<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\Documento;

class DocumentoComp
{   
    public function getDocumentos($id_conv){
        $requests=Documento::where('id_convocatoria', $id_conv)
                            ->orderBy('id', 'ASC')
                            ->get();
        return $requests;
    }
}
