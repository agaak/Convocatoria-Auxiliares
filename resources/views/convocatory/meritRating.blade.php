@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

    <h3 class="text-uppercase text-center">Calificación de Méritos</h3>

    {{-- Descripcion del contenido y adjunto un icono para edita esta descripcion en un modal --}}
    <div class="row">
        <div class="card border-dark mb-3 col-md-11">
            <div class="card-body">
                <p class="card-text">La calificación de méritos se se basará en los documentos
                    presentados por el postulante y se realizará sobre la base de <strong> 100 </strong> puntos,
                    que representa el <strong> 10% </strong>
                    de la calificación final.</p>
            </div>
        </div>
        <a class="col-md-1 my-auto" type="button" data-toggle="modal" data-target="#porcentageModal">
            <img src="{{ asset('img/pen.png') }}" width="30" height="30">
        </a>
    </div>
    {{-- Modal de la descripcion del contenido para cambiar dato nota y porcentaje --}}
    <div class="modal fade" id="porcentageModal" tabindex="-1" role="dialog" aria-labelledby="porcentageMeritModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="porcentageMeritModal">Porcentaje de evaluación</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('meritRatingValid') }}"
                        id="points-merit-form">
                        {{ csrf_field() }}
                        <p>
                            <span class="font-weight-bold">La calificación de méritos</span> se basará en los documentos
                            presentados por el postulante:
                        </p>
                        <div class="form-row my-4 bg-light">
                            <span class="my-auto">Se calificará sobre la base de:</span>
                            <input type="number" class="form-control col-sm-2 mx-2" name="puntos-calificacion"
                                placeholder="100" min="0" max="100" required>
                            <span class="my-auto">puntos</span>
                        </div>
                        <div class="form-row my-4 bg-light">
                            <span class="my-auto">Que representa el:</span>
                            <input type="number" class="form-control col-sm-2 mx-2" name="porcentaje-merito"
                                id="porcent-merit" placeholder="%" min="0" max="100" required>
                            <span class="my-auto">% de la nota final</span>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="points-merit-form">
                </div>
            </div>
        </div>
    </div>
    {{-- Botones para añadir merito y submerito que ademas abren el modal respectivo --}}
    <div class="row my-3" style="margin-left: 3ch">
        <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#meritModal">
            <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
            <span class="mx-1">Añadir mérito</span>
        </a>
        <a class="text-decoration-none" style="margin-left: 15px" type="button" data-toggle="modal"
            data-target="#subMeritModal">
            <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
            <span class="mx-1">Añadir submérito</span>
        </a>
    </div>
    {{-- Modal de editar merito --}}
    <div class="modal fade" id="meritModalEdit" tabindex="-1" role="dialog" aria-labelledby="meritModalTitleEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meritModalTitleEdit">Actualizar mérito</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('meritRatingUpdate') }}" id="merit-form-update">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" name="id-merito" id="id-merit-input" value="">
                        <div class="form-row my-2">
                            <label class="col-3" for="description-merit-edit">Descripción:</label>
                            <textarea class="form-control col-sm" name="descripcion-merito" id="description-merit-edit"
                                rows="3" placeholder="Ingrese la descripción del mérito" required></textarea>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3 col-form-label" for="porcent-merit-edit">Porcentaje:</label>
                            <input type="number" class="form-control col-sm-3" name="porcentaje-merito"
                                id="porcent-merit-edit" placeholder="%" min="0" max="100" required>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="merit-form-update">
                </div>
            </div>
        </div>
    </div>
    {{-- Modal del añadir merito --}}
    <div class="modal fade" id="meritModal" tabindex="-1" role="dialog" aria-labelledby="meritModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meritModalTitle">Añadir nuevo mérito</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('meritRatingValid') }}" id="merit-form">
                        {{ csrf_field() }}
                        <div class="form-row my-2">
                            <label class="col-3" for="description-merit">Descripción:</label>
                            <textarea class="form-control col-sm" name="descripcion-merito" id="description-merit"
                                rows="3" placeholder="Ingrese la descripción del mérito" required></textarea>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3 col-form-label" for="porcent-merit">Porcentaje:</label>
                            <input type="number" class="form-control col-sm-3" name="porcentaje-merito"
                                id="porcent-merit" placeholder="%" min="0" max="100" required>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="merit-form">
                </div>
            </div>
        </div>
    </div>
    {{-- Modal para editar submerito --}}
    <div class="modal fade" id="subMeritModalEdit" tabindex="-1" role="dialog" aria-labelledby="subMeritModalTitleEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subMeritModalTitleEdit">actualizar submérito</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('meritRatingUpdate') }}" id="sub-merit-form-edit">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" id="id-sub-merit-input" name="id-submerito">

                        <div class="form-row my-2">
                            <label class="col-3" for="merit-sub-merit">Mértio / submérito</label>
                            <div class="col-sm">
                                <select class="form-control" id="merit-sub-merit" name="merito-o-submerito">
                                    @foreach ($listaOrdenada as $item)
                                    <option value="{{ $item[3] }}" id="id-option-{{$item[3]}}"> {{ $item[1] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3" for="description-sub-merit">Descripción:</label>
                            <textarea class="form-control col-sm" name="descripcion-sub-merito"
                                id="description-sub-merit" rows="3" placeholder="Ingrese la descripción del mérito"
                                required></textarea>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3 col-form-label" for="porcent-sub-merit">Porcentaje:</label>
                            <input type="number" class="form-control col-sm-3" name="porcentaje-sub-merito"
                                id="porcent-sub-merit" placeholder="%" required min="0" max="100">
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="sub-merit-form-edit">
                </div>
            </div>
        </div>
    </div>
    {{-- Modal del añadir submerito --}}
    <div class="modal fade" id="subMeritModal" tabindex="-1" role="dialog" aria-labelledby="subMeritModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subMeritModalTitle">Añadir nuevo submérito</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('meritRatingValid') }}" id="sub-merit-form">
                        {{ csrf_field() }}
                        <div class="form-row my-2">
                            <label class="col-3" for="merit-sub-merit">Mértio / submérito</label>
                            <div class="col-sm">
                                <select class="form-control" id="merit-sub-merit" name="merito-o-submerito">
                                    @foreach ($listaOrdenada as $item)
                                    <option value="{{ $item[3] }}"> {{ $item[1] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3" for="description-sub-merit">Descripción:</label>
                            <textarea class="form-control col-sm" name="descripcion-sub-merito"
                                id="description-sub-merit" rows="3" placeholder="Ingrese la descripción del mérito"
                                required></textarea>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3 col-form-label" for="porcent-sub-merit">Porcentaje:</label>
                            <input type="number" class="form-control col-sm-3" name="porcentaje-sub-merito"
                                id="porcent-sub-merit" placeholder="%" required min="0" max="100">
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="sub-merit-form">
                </div>
            </div>
        </div>
    </div>
    {{-- Tabla de merito y submeritos --}}

    @php
        function espacios($cadena) {
            $contar = 0;
            for ($i=0; $i < strlen($cadena) ; $i++) {
                $contar +=10; if ($cadena[$i]==')' ) { break; } 
            }
            return $contar-8; 
        }

        function convertir($arreglo) {
            return json_encode($arreglo);
        }
    @endphp
    <div class="table-requests">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="font-weight-normal" scope="col">Descripcion de Meritos</th>
                    <th class="font-weight-normal" scope="col">Porcentaje</th>
                    <th class="font-weight-normal" scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($listaOrdenada  as $item)
                    <tr>
                        <td class="{{ $item[0] === null? 'text-uppercase font-weight-bold': 'text-lowercase' }}"
                            style="padding-left: {{ espacios($item[1]) }}px;">{{ $item[1] }}</td>
                        <td class="text-center">{{ $item[2] }}</td>
                        <td class="text-center">
                            @if ($item[0] === null)
                            <a type="button" data-toggle="modal" data-target="#meritModalEdit" onclick="editMeritModal({{ convertir($item) }})">
                                <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                            </a>
                            @else
                            <a type="button" data-toggle="modal" data-target="#subMeritModalEdit"
                                onclick="editSubMeritModal({{ convertir($item) }})">
                                <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                            </a> 
                            @endif
                            <form class="d-inline" action="{{ route('meritRatingDelete', $item[3]) }}" method="POST" id="merit-delete">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">
                                    <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="my-5 text-center">
        <a href="{{ route('knowledgeRating') }}" type="button" class="btn btn-info my-5">Siguiente</a>
    </div>
</div>
@endsection