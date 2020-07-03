@extends('layout')

@section('content')
    <div class="overflow-auto content" style="width: 100vw; height: 77vh;">
    
        <h3 class="text-uppercase text-left">Convocatorias Pasadas</h3>
        <label class="mdb-main-label">Filtrar convocatorias:</label>
        <form method="POST" action="{{ route('convsPasadasBuscar') }}" id="convsPasadasSearch">
            {{ csrf_field() }}
        <div class="form-row text-center">
                <div class="col-sm-3">
                    <div class="form-group">
                        <select class="form-control" id="conv-dept" name="conv-dept">
                            <option disabled>Departamento</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->id }}"
                                    {{-- {{ old('conv-dept') == $dep->id == $idDepartamento? 'selected': '' }}> --}}
                                    {{ $dep->id == $idDepartamento??1 ?'selected': '' }}>
                                    {{ $dep->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <select class="form-control" id="conv-tipo" name="conv-tipo">
                            <option selected disabled>Tipo de Conv.</option>
                            @foreach($tipos as $item)
                                <option value="{{ $item->id }}"
                                    {{-- {{ old('conv-tipo') == $item->id == $idTipoConv ? 'selected': '' }}> --}}
                                    {{ $item->id == $idTipoConv??1 ? 'selected': '' }}>
                                    {{ $item->nombret_tipo }}</option>
                            @endforeach
                            <option value="">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <select class="form-control" id="conv-gestion" name="conv-gestion">
                            <option selected disabled>Gestion</option>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion }}"
                                {{-- {{ old('conv-gestion') == $gestion == $selectGestion? 'selected': '' }}> --}}
                                {{ $gestion == $selectGestion??2019 ? 'selected': '' }}>
                                    {{ $gestion }}</option>
                            @endforeach
                            <option value="">Todos</option>
                        </select>
                    </div>
                </div>
        </div>
    </form>
    
    <div class="col-sm-1">
        <button class="btn btn-dark btn-rounded btn-sm my-0 " type="submit" form="convsPasadasSearch">Buscar</button>
    </div>
        {{-- Carrusel de cards con datos grals. de una convocatoria --}}
        @if (auth()->check())        
            @if (auth()->user()->hasRoles(['administrador']))
                @component('components.carruselConvocatoria', 
                    ['convos' => $convosPasadas, 'auxs' => $auxs])
                @endcomponent 
            @else 
                @component('components.carruselConvocatoria', 
                    ['convos' => $convosPasadas, 'auxs' => $auxs])
                @endcomponent 
            @endif
        @else
            @component('components.carruselConvocatoria', 
                ['convos' => $convosPasadas, 'auxs' => $auxs])
            @endcomponent 
        @endif
    
        </div>
        <script>
            $(document).ready(function() {
$('.mdb-select').materialSelect();
});
        </script>
@endsection