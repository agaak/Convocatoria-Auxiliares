<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\RequerimientoRequest;
use App\Http\Requests\Convocatoria\RequerimientoCreateRequest;
use Illuminate\Support\Facades\DB;
use App\Requerimiento;
class RequerimientoController extends Controller
{
    public function create(RequerimientoCreateRequest $request){  
        Requerimiento::create([
            'id_convocatoria'=>4,//$request->session()->get('convocatoria'),
            'nombre'=>$request->get('nombre'),
            'item'=>7,
            'cantidad'=>$request->get('codigo_pro'),
            'horas_mes'=>$request->get('marca'),
            'cod_aux'=>56
        ]);
        return back();
    }

    public function update(Request $request){
        DB::table('requerimiento')->where('id', $request->input('id-request'))->update([
            'nombre' => $request->input('nombre-request'),
            'item' => $request->input('item-request'),
            'horas_mes' => $request->input('horas_mes-request'),
            'cantidad' => $request->input('cantidad-request'),
            'cod_aux' => $request->input('cod_aux-request')
        ]);
        return back();
    }

    public function delete($id){
        DB::table('requerimiento')->where('id', $id)->delete();
        return redirect()->route('requests');
    }

    public function requests(Request $request){
        $requests=DB::table('requerimiento')
            ->where('id_convocatoria', 4)//$request->session()
            //->get('convocatoria'))
            ->get();
        $auxs=DB::table('auxiliatura')
            //->where('tipo',$request->session()
            //->get('tipo'))
            ->get();//*/
        //$auxs=['Introduccion a la Progra','Elementos'];
        return view('convocatory.requerimientos', compact('requests','auxs')); 
    }
}
