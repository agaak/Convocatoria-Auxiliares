<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Documento;
class DocumentoController extends Controller
{
    public function documentoValid(Request $request){
        $documento = new Documento();
        $documento -> id_convocatoria=$request->session()->get('convocatoria');
        $documento -> descripcion=$request->get('descripcion');
        $documento -> save();
        return back();
    }

    public function documentoUpdate(Request $request){
        DB::table('documento')->where('id', $request->input('id-requirement'))->update([
            'descripcion' => $request->input('descripcion-requirement') ]);
        return back();
    }

    public function documentoDelete($id){
        DB::table('documento')->where('id', $id)->delete();
        return back();
    }

    public function documentos(Request $request){ //Si no funciona comentar where
        $documentos=DB::table('documento')->get();//where('id_convocatoria', $request->session()->get('convocatoria'))->get();
        $convActual = request()->session()->get('convocatoria');
        $notaActual = DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->exists();
        $datoNotaDoc = null;
        if ($notaActual) {
            $datoNotaDoc = DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->get()[0];
        }

        return view('convocatory.documentos', compact('documentos', 'datoNotaDoc')); // return $documentos; := carga los datos de la tabla como [] 
    }
}
