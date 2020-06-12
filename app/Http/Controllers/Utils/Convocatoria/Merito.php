<?php

namespace App\Http\Controllers\Utils\Convocatoria;

use App\Merito;

class Merito
{   
    public function getMeritos($id_conv){
        
        $meritList = Merito::where('id_convocatoria', $id_conv)
                            ->orderBy('id', 'ASC')
                            ->get();

        $llenarLista = [];
        $listaInicial = [];
        foreach ($meritList as $value) {
            $listaInicial = [];
            array_push($listaInicial, $value->id_submerito);
            array_push($listaInicial, $value->descripcion_merito);
            array_push($listaInicial, $value->porcentaje);
            array_push($listaInicial, $value->id);
            $llenarLista[$value->id] = $listaInicial;
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

        return $listaOrdenada;
    }
}
