@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content">
        <h3>Notas de Meritos</h3>
        @component('components.calificaciones.tablaPostulantesMeritos',['postulantes'=>$postulantes])
        @endcomponent
    </div>
@endsection