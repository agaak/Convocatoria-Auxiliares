@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="overflow-auto content">
        @php
            function espacios($cadena) {
                $contar = 0;
                for ($i=0; $i < strlen($cadena) ; $i++) {
                    $contar +=10; 
                    if ($cadena[$i]==')' ) { 
                        break; 
                    }
                }
                return $contar-8;
            }

            function convertir($arreglo) {
                return json_encode($arreglo);
            }
        @endphp
        @component('components.calificaciones.tablaCalificacionesMerito',['lista'=>$lista])
        @endcomponent
    </div>
@endsection