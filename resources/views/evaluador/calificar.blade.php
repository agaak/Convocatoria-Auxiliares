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
                        <a class="card-personal-title border" href="{{ route('calificarRequisitosPost.index') }}">Requisito</a>
                    </div>
                    <div class="col-sm-6">
                        <a class="card-personal-title border" href="{{ route('calificarMerito.index') }}">Merito</a>
                    </div>
                </div>
            @endif
            @if ($rol->nombre == 'Conocimientos')
                    <h5 class="mb-4 font-weight-bold text-center text-uppercase">{{ $tipoConv === 1? 'Temáticas': 'Auxiliaturas' }}</h5>
                    <div class="d-flex justify-content-around flex-wrap">
                        @foreach ($auxsTemsEval as $item) 
                                <div class="border border-dark mb-3">
                                    <h5 class="card-personal-body text-center font-weight-bold m-0">{{ $item->nombre }}</h5>
                                    <ul class="text-center p-0">
                                        @foreach ($item['areas'] as $area)
                                            <li class="menu-link">
                                                <a class="font-weight-bold text-info" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => $area->id_area]) }}">{{  $area->area }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                    </ul>
                </li>
                
            @endif
            
        @endforeach
                
    </div>
    
@endsection