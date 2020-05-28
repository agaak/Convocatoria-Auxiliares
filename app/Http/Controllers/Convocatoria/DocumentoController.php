<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    public function documentoValid(Request $request){
        Requisito::create([
            'id_convocatoria'=>$request->session()->get('convocatoria'), 
            'descripcion'=>$request->get('descripcion')
        ]);
        $requerimients=Requisito::get()->where('id_convocatoria', $request->session()->get('convocatoria'));
        return view('convocatory.documentos', compact('requerimients'));
    }

    public function documentoUpdate(Request $request){
        DB::table('requisito')->where('id', $request->input('id-requirement'))->update([
            'descripcion' => $request->input('descripcion-requirement') ]);
        return back();
    }

    public function documentoDelete($id){
        DB::table('requisito')->where('id', $id)->delete();
        return back();
    }

    public function documentos(Request $request){ //Si no funciona comentar where
        $documentos=DB::table('requisito')->get();//where('id_convocatoria', $request->session()->get('convocatoria'))->get();

        return view('convocatory.documentos', compact('documentos')); // return $documentos; := carga los datos de la tabla como [] 
    }
}
