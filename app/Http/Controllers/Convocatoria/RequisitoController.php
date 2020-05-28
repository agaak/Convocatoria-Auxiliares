<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Convocatoria\RequisitoCreateRequest;
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
        DB::table('requisito')->where('id', $request->input('id-requirement'))->update([
            'descripcion' => $request->input('descripcion-requirement') ]);
        return back();
    }

    public function requirementDelete($id){
        DB::table('requisito')->where('id', $id)->delete();
        return back();
    }

    public function requirements(Request $request){
        $requerimients=DB::table('requisito')->
            where('id_convocatoria', $request->session()->get('convocatoria'))
            ->get();
        return view('convocatory.requisitos', compact('requerimients'));
    }
}
