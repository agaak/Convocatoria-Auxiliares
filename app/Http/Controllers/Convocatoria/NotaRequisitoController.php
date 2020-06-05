<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class NotaRequisitoController extends Controller
{
    public function store() {
        $convActual = request()->session()->get('convocatoria');

        if (DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 1)->exists()) {
            if (request()->input('nota-requisito') === null) {
                DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 1)->update([
                    'integer' => ''
                ]);
            } else {
                DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 1)->update([
                    'integer' => request()->input('nota-requisito')
                ]);
            }
            
        } else {
            DB::table('nota')->insert([
                'id_tipo_nota' => 1,
                'id_convocatoria' => $convActual,
                'integer' => request()->input('nota-requisito')
            ]);
        }

        return back();
    }
}
