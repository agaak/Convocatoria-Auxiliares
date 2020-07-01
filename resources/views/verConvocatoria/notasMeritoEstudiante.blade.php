@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content center">
        <h1>NOTAS MERITO</h1>
        <h3>
            {{ $estudiante[0]->nombre }} {{ $estudiante[0]->apellido }}
        </h3>

        @php
        function espacios($cadena) {
            $contar = 0;
            for ($i=0; $i < strlen($cadena) ; $i++) {
                $contar +=10; if ($cadena[$i]==')' ) { break; }
            }
            return $contar-8;
        }

        
        @endphp
        
        @component('components.calificaciones.tablaCalificacionesMerito',['lista'=>$lista, 'listaMeritos'=>$listaMeritos])
        @endcomponent
        <div class="col-7">
            <div class="float-right">
            <a class="btn btn-secondary center" href="{{ route('notasMerito') }}">Cancelar</a>
            </div>
        </div>
    </div>
    
@endsection
    