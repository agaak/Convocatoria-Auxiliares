<?php

namespace App\Http\Controllers\Convocatoria;

use App\Convocatoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\RequerimientoCreateRequest;
use Illuminate\Support\Facades\DB;
use App\Requerimiento;
class RequerimientoController extends Controller
{
    public function create(RequerimientoCreateRequest $request){  
        $aux = explode('|', $request->get('id-aux'));
        $res = DB::table('auxiliatura')
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
        $id_conv = $request->session()->get('convocatoria');
        $tipo = DB::table('convocatoria')->where('id',$id_conv)
            ->value('id_tipo_convocatoria');
        $requests=Requerimiento::select('requerimiento.*','nombre_aux','cod_aux')
            ->join('auxiliatura','requerimiento.id_auxiliatura', '=','auxiliatura.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->get();
        $auxs_res = [];
        foreach($requests as $aux){
            array_push($auxs_res, $aux->id_auxiliatura);    
        }
        $auxs=DB::table('auxiliatura')->where('id_unidad_academica',1)
            ->where('id_tipo_convocatoria',$tipo)
            ->whereNotIn('id', $auxs_res)->get();
        
        return view('convocatory.requerimientos', compact('requests','auxs')); 
    }
}
