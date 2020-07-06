@extends('layout')

@section('content')
<div class="overflow-auto content" style="width: 100vw; height: 77vh;">
        <h3 class="text-uppercase text-left">Avisos</h3>
        
        {{-- Carrusel de cards con datos grals. de un aviso --}}
        @component('components.carruselAviso', 
        ['listAvisos' => $listAvisos])
        @endcomponent
    </div>
@endsection