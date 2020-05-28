<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Requerimiento;
class RequerimientoController extends Controller
{
    public function requestValid(Request $request){        
        Requerimiento::create([
            'id_convocatoria'=>$request->session()->get('convocatoria'),
            'nombre'=>$request->get('nombre'),
            'item'=>$request->get('item'),
            'cantidad'=>$request->get('codigo_pro'),
            'horas_mes'=>$request->get('marca'),
            'cod_aux'=>$request->get('precio')
        ]);
        return back();
    }

    public function requestUpdate(Request $request){
        DB::table('requerimiento')->where('id', $request->input('id-request'))->update([
            'nombre' => $request->input('nombre-request'),
            'item' => $request->input('item-request'),
            'horas_mes' => $request->input('horas_mes-request'),
            'cantidad' => $request->input('cantidad-request'),
            'cod_aux' => $request->input('cod_aux-request')
        ]);
        return back();
    }

    public function requestDelete($id){
        DB::table('requerimiento')->where('id', $id)->delete();
        return redirect()->route('requests');
    }

    public function requests(Request $request){
        $requests=DB::table('requerimiento')->where('id_convocatoria', $request->session()->get('convocatoria'))->get();

        return view('convocatory.requerimientos', compact('requests')); 
    }
}
