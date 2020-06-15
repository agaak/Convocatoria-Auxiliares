<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Convocatoria\RequisitoCreateRequest;
use App\Http\Controllers\Utils\Convocatoria\RequisitoComp;
use App\Requisito;
class RequisitoController extends Controller
{
    public function requirementsValid(RequisitoCreateRequest $request){
        $requisito = new Requisito();
        $requisito -> id_convocatoria=$request->session()->get('convocatoria');
        $requisito -> descripcion=$request->get('descripcion');
        $requisito -> save();
        return back();
    }

    public function requirementUpdate(Request $request){
        $convActual = request()->session()->get('convocatoria');
        $idRequerimiento = request()->input('id-requirement');
        request()->validate([
            'descripcion-edit'=> 'required|unique:requisito,descripcion,'.$idRequerimiento.',id,id_convocatoria,'.$convActual
        ],[
            'descripcion-edit.unique' => 'El Requisito ya ha sido registrado.'
        ]);
        Requisito::where('id', $request->input('id-requirement'))->update([
            'descripcion' => $request->input('descripcion-edit') ]);
        return back();
    }

    public function requirementDelete($id){
        DB::table('requisito')->where('id', $id)->delete();
        return back();
    }

    public function requirements(Request $request){
        $convActual = request()->session()->get('convocatoria');
        $requerimients = (new RequisitoComp)->getRequisitos($convActual);
        $notaActual = DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 1)->exists();
        $datoNota = null;
        if ($notaActual) {
            $datoNota = DB::table('nota')->where('id_convocatoria', $convActual)->where('id_tipo_nota', 1)->get()[0];
        }
        return view('convocatory.requisitos', compact('requerimients', 'datoNota'));
    }
}
