@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
<div class="contenido-mis-convocatorias overflow-auto">
    @foreach ($convs as $conv)
        @if ($conv->id == session()->get('convocatoria'))
            <p class="text-center"><span class="text-uppercase font-weight-bold border-bottom border-dark">{{ $conv->titulo }}</span></p>
        @endif
    @endforeach
        <h5 class="mt-4 font-weight-bold text-center text-uppercase">Calificar</h5>
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
                    <h5 class="mb-4 font-weight-bold text-center text-uppercase">{{ $tipoConv === 1? 'Temáticas': 'Auxiliaturas' }}</h5>
                        @foreach ($auxsTemsEval as $item) 
                            <div class="card-personal text-center">
                                <h5 class="card-personal-body font-weight-bold">{{ $item->nombre }}</h5>
                                <div class="row w-100 m-0">
                                    @foreach ($item['areas'] as $area)
                                        <div class="col-sm p-0 border border-info">
                                            <a class="card-personal-title" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => $area->id_area]) }}">{{  $area->area }}</a>
                                            <p class="card-personal-body">Descripción de las temáticas de esta convocatoria</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </li>
                
            @endif
            
        @endforeach
                
    </div>
    
@endsection