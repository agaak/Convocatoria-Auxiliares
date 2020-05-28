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
        $req = new Requerimiento();
        $req ->id_convocatoria =  $request->session()->get('convocatoria');
        $req ->id_auxiliatura = $request->input('id');
        $req ->horas_mes = $request->input('horas');
        $req ->cant_aux = $request->input('cantidad');
        $req -> save();
        return  back();
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
        $tipo = DB::table('convocatoria')->select('id_tipo_convocatoria')->
                where('id',$request->session()->get('convocatoria'))
                ->get();
        $auxs=DB::table('auxiliatura')
            ->where('id_unidad_academica',1)
            ->get();
        $requests=Requerimiento::select('requerimiento.id','horas_mes','requerimiento.cant_aux','nombre_aux','cod_aux')
            ->join('auxiliatura','requerimiento.id_auxiliatura', '=','auxiliatura.id')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->get();
        return view('convocatory.requerimientos', compact('requests','auxs')); 
    }
}
