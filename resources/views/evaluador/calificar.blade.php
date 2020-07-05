@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
<div class="contenido-mis-convocatorias overflow-auto">
    @foreach ($convs as $conv)
        @if ($conv->id == session()->get('convocatoria'))
            <p class="text-center"><span class="text-uppercase font-weight-bold border-bottom border-dark">{{ $conv->titulo }}</span></p>
        @endif
    @endforeach
        <h4 class="m-4 font-weight-bold text-center">CALIFICAR</h4>
        @foreach ($roles as $rol)
            @if ($rol->nombre == 'Meritos')
                <div class="row text-center my-4">
                    <div class="col-sm-6">
                        <div class="card-personal">
                            <a class="card-personal-title" href="{{ route('calificarRequisitosPost.index') }}">Requisito</a>
                            <p class="card-personal-body">Descripción de los requisitos de esta convocatoria</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-personal">
                            <a class="card-personal-title" href="{{ route('calificarMerito.index') }}">Merito</a>
                            <p class="card-personal-body">Descripción de los requisitos de esta convocatoria</p>
                        </div>
                    </div>
                </div>
            @endif
            @if ($rol->nombre == 'Conocimientos')
                    <h4 class="m-4 font-weight-bold text-center text-uppercase">{{ $tipoConv === 1? 'Temáticas': 'Auxiliaturas' }}</h4>
                        @foreach ($auxsTemsEval as $item)
                            @if ($tipoConv === 1)
                                <div class="card-personal">
                                    <a class="card-personal-title" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => 'todos']) }}">{{ $item->nombre }}</a>
                                    <p class="card-personal-body">Descripción de las temáticas de esta convocatoria</p>
                                </div>
                            @else
                                <div class="card-personal text-center">
                                    <h4 class="card-personal-body font-weight-bold">{{ $item->nombre }}</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a class="card-personal-title" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => 'oral']) }}">Examen Oral</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a class="card-personal-title" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => 'escrito']) }}">Examen Escrito</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </li>
                
            @endif
            
        @endforeach
                
    </div>
    
@endsection