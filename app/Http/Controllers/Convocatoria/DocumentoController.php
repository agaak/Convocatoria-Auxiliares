<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utils\Convocatoria\DocumentoComp;
use App\Models\Documento;
class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('view');
    }
    public function documentoValid(Request $request){
        $convActual = request()->session()->get('convocatoria');
        request()->validate([
            'descripcion'=> 'required|unique:documento,descripcion,0,id,id_convocatoria,'.$convActual
        ]);
        $documento = new Documento();
        $documento -> id_convocatoria=$convActual;
        $documento -> descripcion=$request->get('descripcion');
        $documento -> save();
        return back();
    }

    public function documentoUpdate(Request $request){
        $convActual = request()->session()->get('convocatoria');
        $idDocumento = $request->input('id-requirement');
        request()->validate([
            'descripcion-edit'=> 'required|unique:documento,descripcion,'.$idDocumento.',id,id_convocatoria,'.$convActual
        ],[
            'descripcion-edit.unique' => 'El Documento ya ha sido registrado.'
        ]);
        DB::table('documento')->where('id', $idDocumento)->update([
            'descripcion' => $request->input('descripcion-edit') ]);
        return back();
    }

    public function documentoDelete($id){
        DB::table('documento')->where('id', $id)->delete();
        return back();
    }

    public function documentos(Request $request){
        $convActual = request()->session()->get('convocatoria');
        $documentos= (new DocumentoComp)->getDocumentos($convActual);
        $notaActual = DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->exists();
        $datoNotaDoc = null;
        if ($notaActual) {
            $datoNotaDoc = DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 2)->get()[0];
        }

        return view('convocatory.documentos', compact('documentos', 'datoNotaDoc')); // return $documentos; := carga los datos de la tabla como [] 
    }
}
