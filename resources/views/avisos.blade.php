@extends('layout')

@section('content')
    <div class="overflow-auto content">
        <h3 class="text-uppercase text-left">Avisos</h3>
        @foreach($listAvisos as $aviso)
            {{-- Visualizar card de aviso --}}
            @component('components.cardAviso', 
            ['aviso' => $aviso])
            @endcomponent
        @endforeach
    </div>
@endsection