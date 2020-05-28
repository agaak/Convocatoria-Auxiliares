<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Requisito;
class RequisitoController extends Controller
{
    public function requirementsValid(Request $request){
        Requisito::create([
            'id_convocatoria'=>$request->session()->get('convocatoria'), 
            'descripcion'=>$request->get('descripcion')
        ]);
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
