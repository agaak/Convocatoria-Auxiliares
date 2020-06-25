<?php

namespace App\Http\Controllers\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Convocatoria\RequerimientoCreateRequest;
use App\Http\Controllers\Utils\Convocatoria\RequerimientoComp;
use Illuminate\Support\Facades\DB;
use App\Models\Requerimiento;
use App\Models\Porcentaje;

class RequerimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('view');
    }

    public function create(RequerimientoCreateRequest $request){  
        $id_conv = $request->session()->get('convocatoria');
        $aux = explode('|', $request->get('id-aux'));
        $res = DB::table('auxiliatura')
            ->join('requerimiento', 'auxiliatura.id','=','requerimiento.id_auxiliatura')
            ->where('requerimiento.id_convocatoria','=',$id_conv)
            ->where('auxiliatura.nombre_aux',$aux[0])->get();
        if(count($res)==0){
            $req = new Requerimiento();
            $req ->id_convocatoria =  $id_conv;
            $req ->id_auxiliatura = $aux[1];
            $req ->horas_mes = $request->get('horas');
            $req ->cant_aux = $request->get('cantidad');
            $req -> save();
            $porcen = Porcentaje::select('id_tematica')
            ->join('requerimiento', 'porcentaje.id_requerimiento', '=', 'requerimiento.id')
            ->where('requerimiento.id_convocatoria',$id_conv)
            ->join('tematica','porcentaje.id_tematica','=','tematica.id')
            ->groupBy('id_tematica')->get();
                foreach($porcen as $porcentaje){
                    $por = new Porcentaje(); 
                    $por -> id_requerimiento = $req->id;
                    $por -> id_auxiliatura =  $aux[1];
                    $por -> id_tematica = $porcentaje->id_tematica; 
                    $por -> porcentaje = 0; 
                    $por -> save();
                }
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
        $requests= (new RequerimientoComp)->getRequerimientos($id_conv);
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
