<?php

namespace App\Http\Controllers\Evaluador;

use App\EvaluadorConocimientos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Postulante;
use Illuminate\Support\Facades\DB;

class CalificacionMController extends Controller
{
    public function index($id){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        session()->put('convocatoria',$id);
        $postulantes= Postulante::select('postulante.*', 'calf_final_postulante_merito.nota_final_merito as nota')
        ->join('calf_final_postulante_merito', 'calf_final_postulante_merito.id_postulante', '=', 'postulante.id')
        ->where('calf_final_postulante_merito.id_convocatoria', session()->get('convocatoria'))
        ->get();
        return view('evaluador.calificarMeritos', compact('convs', 'id', 'postulantes'));
    }

    public function calificarMeritos( $idEst){
        $convs = EvaluadorConocimientos::where('correo', auth()->user()->email)->first()->convocatorias;
        $id= session()->get('convocatoria');
        $lista=$this->ordenar($id, $idEst); 
        return view('evaluador.calificarMeritosEstudiante',compact('convs','id', 'lista'));
    }

    function ordenar($id, $idEst){
        $meritList = DB::table('calificacion_merito')->select('merito.*', 'calificacion_merito.calificacion as calificacion')
                        ->join('merito', 'merito.id', '=', 'calificacion_merito.id_merito')
                        ->where('merito.id_convocatoria', $id)
                        ->where('calificacion_merito.id_postulante', $idEst)
                        ->get();
        $llenarLista = [];
        $listaInicial = [];
        foreach ($meritList as $value) {
            $listaInicial = [];
            array_push($listaInicial, $value->id_submerito);
            array_push($listaInicial, $value->descripcion_merito);
            array_push($listaInicial, $value->porcentaje);
            array_push($listaInicial, $value->id);
            array_push($listaInicial, $value->calificacion);
            array_push($listaInicial, false);
            $llenarLista[$value->id] = $listaInicial;
        } 
        function buscarPerteneciente($original, $identificador, $arreglo, $caracteres, $cadena) {
            $contador = 1;
            $cadenaTempral = "";
            foreach ($original as $key => $value) {
                if ($value[0] !== null) {
                    $value[5]=true;
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

        return $listaOrdenada;
    }
}
