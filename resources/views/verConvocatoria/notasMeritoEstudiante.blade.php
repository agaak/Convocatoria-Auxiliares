@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content center">
        <h3>Detalles de Notas de Meritos</h3>
        <h6>
            {{ $estudiante[0]->nombre }} {{ $estudiante[0]->apellido }}
        </h6>

        @php
        function espacios($cadena) {
            $contar = 0;
            for ($i=0; $i < strlen($cadena) ; $i++) {
                $contar +=10; if ($cadena[$i]==')' ) { break; }
            }
            return $contar-8;
        }

        
        @endphp
        
        @component('components.calificaciones.tablaCalificacionesMerito',['lista'=>$lista, 'listaMeritos'=>$listaMeritos, 'm_total'=>$notaFinalMerito[0]->m_total])
        @endcomponent
        <div class="col-7">
            <div class="float-right">
            <a class="btn btn-secondary center" href="{{ route('notasMerito') }}">Cancelar</a>
            </div>
        </div>
    </div>
    
@endsection
    