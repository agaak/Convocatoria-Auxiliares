@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

    <h3>Sección de Calificación de Méritos</h3>

    {{-- Descripcion del contenido y adjunto un icono para edita esta descripcion en un modal --}}
    <div class="row ml-1 mr-1 {{session()->get('ver')? 'my-4': ''}}">
        <div class="card border-dark {{session()->get('ver')? 'col-md-12': 'col-md-11'}}">
            <div class="card-body">
                <p class="card-text">La calificación de méritos se se basará en los documentos
                    presentados por el postulante y se realizará sobre la base de <strong> 100 </strong> puntos,
                    que representa el <strong> {{ $porcentajesConvocatoria->porcentaje_merito??"_ _ _" }}% </strong>
                    de la calificación final.</p>
            </div>
        </div>
        @if (!session()->get('ver'))
            <a class="col-md-1 my-auto text-center" type="button" data-toggle="modal" data-target="#porcentajeModal"
                onclick="editPorcentajes({{ $porcentajesConvocatoria->porcentaje_merito??0 }})" >
                <img src="{{ asset('img/pen.png') }}" width="30" height="30">
            </a>
        @endif
    </div>

    {{-- Modal de la descripcion del contenido para cambiar dato nota y porcentaje --}}

   <div class="modal fade" id="porcentajeModal" tabindex="-1" role="dialog" aria-labelledby="porcentajeMeritModal"
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
                    <form method="POST" action="{{ route('calificacion-meritos.update', 'actualizar') }}"
                        id="points-merit-form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <p>
                            <span class="font-weight-bold">La calificación de méritos</span> se basará en los documentos
                            presentados por el postulante:
                        </p>
                        <div class="form-row my-4 bg-light">
                            <span class="my-auto">Se calificará sobre la base de: 100 puntos.</span>
                        </div>
                        <div class="form-row my-4 bg-light">
                            <span class="my-auto">Que representa el:</span>
                            <input type="number" class="form-control col-sm-2 mx-2" name="porcent-merit"
                                id="porcent-merit" placeholder="%" min="1" max="99" required>
                            <span class="my-auto">% de la nota final.</span>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="points-merit-form">
                </div>
            </div>
        </div>
    </div>

    {{-- Botones para añadir merito y submerito que ademas abren los modales respectivos --}}
    @if (!session()->get('ver'))
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
    @endif

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
                    <form method="POST" action="{{ route('calificacion-meritos.update', 'actualizar') }}" id="merit-form-update">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" name="merit-id" id="merit-id" value="">
                        <div class="form-row my-2">
                            <label class="col-3" for="merit-descripcion-edit">Descripción:</label>
                            <textarea class="form-control col-sm" name="merit-descripcion-edit" id="merit-descripcion-edit"
                                rows="3" placeholder="Ingrese la descripción del mérito" required></textarea>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3 col-form-label" for="merit-porcentaje-edit">Porcentaje:</label>
                            <input type="number" class="form-control col-sm-3" name="merit-porcentaje-edit"
                                id="merit-porcentaje-edit" value="{{ old('merit-porcentaje-edit') }}" placeholder="%" min="0" max="100" required>
                        </div>
                        {!! $errors->first('merit-porcentaje-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="merit-form-update" class="btn btn-info" id="limpiar-espacio">Guardar</button>
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
                    <form method="POST" action="{{ route('calificacion-meritos.store') }}" id="merit-form">
                        {{ csrf_field() }}
                        @include('formularios._formMerito')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info" form="merit-form">Guardar</button>
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
                    <form method="POST" action="{{ route('calificacion-meritos.update', 'actualizar') }}" id="submerit-form-edit">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" id="submerit-id" name="submerit-id">

                        <div class="form-row my-2">
                            <label class="col-3" for="merit-submerit">Mértio / submérito</label>
                            <div class="col-sm">
                                <select class="form-control" id="merit-submerit" name="merit-submerit">
                                    @foreach ($listaOrdenada as $item)
                                    <option value="{{ $item[3] }}" id="id-option-{{$item[3]}}"> {{ $item[1] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row my-2">
                            <label class="col-3" for="submerit-descripcion-edit">Descripción:</label>
                            <textarea class="form-control col-sm" name="submerit-descripcion-edit"
                                id="submerit-descripcion-edit" rows="3" placeholder="Ingrese la descripción del mérito"
                                required></textarea>
                        </div>
                        {!! $errors->first('submerit-descripcion-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                        <div class="form-row my-2">
                            <label class="col-3 col-form-label" for="submerit-porcentaje-edit">Porcentaje:</label>
                            <input type="number" class="form-control col-sm-3" name="submerit-porcentaje-edit"
                                id="submerit-porcentaje-edit" placeholder="%" required min="0" max="100">
                        </div>
                        {!! $errors->first('submerit-porcentaje-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info" form="submerit-form-edit">Guardar</button>
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
                    <form method="POST" action="{{ route('calificacion-meritos.store') }}" id="submerit-form">
                        {{ csrf_field() }}
                        <div class="form-row my-2">
                            <label class="col-3" for="merit-submerit">Mértio / submérito</label>
                            <div class="col-sm">
                                <select class="form-control" id="merit-submerit" name="merit-submerit">
                                    @foreach ($listaOrdenada as $item)
                                    <option value="{{ $item[3] }}" {{ old('merit-submerit') == $item[3]? 'selected': ''}}> {{ $item[1] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @include('formularios._formSubMerito')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="submerit-form">
                </div>
            </div>
        </div>
    </div>

    {{-- Funcion ayuda para la tabulacion mostrada en la tabla de meritos y submeritos --}}

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

    {{-- Tabla de merito y submeritos --}}
    @if ($errors->has('merit-descripcion-edit') || $errors->has('merit-porcentaje-edit'))
    <div class="text-center">
        <strong class="text-danger">
            Se econtro un error al editar los datos, para mas detalles revise el 
            formulario del merito que editaba.
        </strong>
    </div>
    @endif
    @if ($errors->has('submerit-descripcion-edit') || $errors->has('submerit-porcentaje-edit'))
    <div class="text-center">
        <strong class="text-danger">
            Se econtro un error al editar los datos, para mas detalles revise el 
            formulario del sub merito que editaba.
        </strong>
    </div>
    @endif

    
  {{-- Visualizar Tabla de meritos --}}
  @component('components.convocatoria.tablaMeritos', 
  ['listaOrdenada' => $listaOrdenada])
  @endcomponent

</div>
@endsection