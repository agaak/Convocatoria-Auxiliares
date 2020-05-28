<?php

namespace App\Http\Controllers\Convocatoria;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MeritoController extends Controller
{
    public function meritRatingDelete($id){
        DB::table('merito')->where('id_merito', $id)->delete();
        return redirect()->route('meritRating');
    }

    public function meritRatingUpdate(Request $request){
        if ($request->has('merito-o-submerito')) {
            DB::table('merito')->where('id_merito', $request->input('id-submerito'))->update([
                'id_sub_merito' => $request->input('merito-o-submerito'),
                'descripcion' => $request->input('descripcion-sub-merito'),
                'porcentaje' => $request->input('porcentaje-sub-merito')
            ]);
        } else {
            DB::table('merito')->where('id_merito', $request->input('id-merito'))->update([
                'descripcion' => $request->input('descripcion-merito'),
                'porcentaje' => $request->input('porcentaje-merito')
            ]);
        }
        
        return redirect()->route('meritRating');
    }

    public function meritRating(){
        $meritList = DB::table('merito')->orderBy('id', 'ASC')->get();

        $llenarLista = [];
        $listaInicial = [];
        foreach ($meritList as $value) {
            $listaInicial = [];
            array_push($listaInicial, $value->id_sub_merito);
            array_push($listaInicial, $value->descripcion);
            array_push($listaInicial, $value->porcentaje);
            array_push($listaInicial, $value->id_merito);
            $llenarLista[$value->id_merito] = $listaInicial;
        }

        function buscarPerteneciente($original, $identificador, $arreglo, $caracteres, $cadena) {
            $contador = 1;
            $cadenaTempral = "";
            foreach ($original as $key => $value) {
                if ($value[0] !== null) {
                    if($value[0] === $identificador) {
                        $cadenaTemporal = $cadena.$contador;
                        $value[1] = chr($caracteres).$cadenaTemporal.') '.$value[1];
                        array_push($arreglo, $value);
                        $arreglo = buscarPerteneciente($original ,$key, $arreglo, $caracteres, $cadenaTemporal.'.');
                        $contador++;
                    }
                }
            }
            return $arreglo;
        }

        $listaOrdenada = [];
        $caracteres = 321;
        foreach ($llenarLista as $key => $value) {
            if ($value[0] === null) {
                $value[1] = chr($caracteres).') '.$value[1];
                array_push($listaOrdenada, $value);
                $listaOrdenada = buscarPerteneciente($llenarLista, $key, $listaOrdenada, $caracteres, '.');
                $caracteres++;
            }
        }

        return view('convocatory.meritos', compact('listaOrdenada'));
    }

    public function meritRatingValid(Request $request){
        if ($request->has('merito-o-submerito')) {
            DB::table('merito')->insert([
                'id_convocatoria' => $request->session()->get('convocatoria'),
                'id_sub_merito' => $request->input('merito-o-submerito'),
                'descripcion_merito' => $request->input('descripcion-sub-merito'),
                'porcentaje' => $request->input('porcentaje-sub-merito')
            ]);
        } else {
            DB::table('merito')->insert([
                'id_convocatoria' => $request->session()->get('convocatoria'),
                'descripcion_merito' => $request->input('descripcion-merito'),
                'porcentaje' => $request->input('porcentaje-merito')
            ]);
        }
        return redirect()->route('meritRating');
    }
}
