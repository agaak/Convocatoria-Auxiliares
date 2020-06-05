<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotaDocController extends Controller
{
    public function store() {
        $convActual = request()->session()->get('convocatoria');

        if (DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->exists()) {
            if (request()->input('nota-doc') === null) {
                DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->update([
                    'integer' => ''
                ]);
            } else {
                DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->update([
                    'integer' => request()->input('nota-doc')
                ]);
            }
            
        } else {
            DB::table('nota')->insert([
                'id_tipo_nota' => 2,
                'id_convocatoria' => $convActual,
                'integer' => request()->input('nota-doc')
            ]);
        }

        return back();
    }
}
