<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\RequerimientoCreateRequest;
use Illuminate\Support\Facades\DB;
use App\Requerimiento;
class RequerimientoController extends Controller
{
    public function create(RequerimientoCreateRequest $request){  
        $aux = explode('|', $request->get('id-aux'));
        $res = DB::table('auxiliatura')//->select('auxiliatura.nombre_aux')
            ->join('requerimiento', 'auxiliatura.id','=','requerimiento.id_auxiliatura')
            ->where('requerimiento.id_convocatoria','=',$request->session()->get('convocatoria'))
            ->where('auxiliatura.nombre_aux',$aux[0])->get();
        if(count($res)==0){
            $req = new Requerimiento();
            $req ->id_convocatoria =  $request->session()->get('convocatoria');
            $req ->id_auxiliatura = $aux[1];
            $req ->horas_mes = $request->get('horas');
            $req ->cant_aux = $request->get('cantidad');
            $req -> save();
        }
        return back();
    }

    public function update(Request $request){
        DB::table('requerimiento')->where('id', $request->input('id-request'))->update([
            'id_auxiliatura' => $request->input('id-aux-request'),
            'horas_mes' => $request->input('horas_mes-request'),
            'cant_aux' => $request->input('cantidad-request')
        ]);
        return back();
    }

    public function delete($id){
        DB::table('requerimiento')->where('id', $id)->delete();
        return back();
    }

    public function requests(Request $request){
        $tipo = DB::table('convocatoria')->select('id_tipo_convocatoria')->
                where('id',$request->session()->get('convocatoria'))
                ->get();
        $auxs=DB::table('auxiliatura')
            ->where('id_unidad_academica',1)
            ->get();
        $requests=Requerimiento::select('requerimiento.id','horas_mes','requerimiento.cant_aux','nombre_aux','cod_aux','requerimiento.id_auxiliatura')
            ->join('auxiliatura','requerimiento.id_auxiliatura', '=','auxiliatura.id')
            ->where('requerimiento.id_convocatoria',$request->session()->get('convocatoria'))
            ->get();
        return view('convocatory.requerimientos', compact('requests','auxs')); 
    }
}
