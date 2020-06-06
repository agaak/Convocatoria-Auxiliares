@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <h3 class="text-uppercase text-center">Comision de evaluacion de meritos</h3>

    <!-- Trigger modal -->
    <button type="button" class="btn btn-dark my-3" data-toggle="modal" 
    data-target="#modalCrearEvaluadorMerit" >Registrar nuevo evaluador</button>
 
    <!-- Table -->
    <div class="table-requests1">
        <table class="table table-bordered" style="text-align:center">
        <thead class="thead-dark">
            <tr> 
            <th style="font-weight: normal" scope="col">CI</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Email</th>
            <th style="font-weight: normal" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
            @foreach($listEvaluadorMerit as $item)
                <tr>
                <th style="font-weight: normal">{{ $item->ci }}</th>
                <th style="font-weight: normal">{{ $item->nombre }}</th>
                <th style="font-weight: normal">{{ $item->apellido }}</th>
                <th style="font-weight: normal">{{ $item->correo }}</th>
                <th>
                    <button type="submit" class="btn btn-link" onclick="editEvaluadorMeritos({{ convertir($item) }})" 
                    data-toggle="modal" data-target="#modalUpdateEvaluadorMerit">
                    <img src="{{ asset('img/pen.png') }}" width="26" height="26">
                    </button> 
                    <form class="d-inline"
                        action="{{ route('admMeritosDelete', $item->id) }}"
                        method="POST" id="evaluador-meritos-delete">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">
                            <img src="{{ asset('img/trash.png') }}" width="26" height="26">
                        </button>    
                    </form>
                </th>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="requestEditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    </div>

    {{--modal crear evaluador de meritos--}}
    <div class="modal fade" id="modalCrearEvaluadorMerit" tabindex="-1" role="dialog"
        aria-labelledby="evaluadorMeritTitleCreate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evaluadorMeritTitleCreate">Registrar evaluador de meritos</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admMeritosCreate') }}"
                        id="form-create-evaluador-merito">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="adm-meritos-ci">CI:</label>
                            <div class="row m-auto">
                                <input type="number" name="adm-meritos-ci" placeholder="Ingrese el número de carnet" class="form-control col-sm-7" 
                                id="adm-meritos-ci" value="{{ old('adm-meritos-ci') }}" required>
                                <button type="button" class="btn btn-primary col-sm-5" onclick="comprobarEvaluadorMerit({{ convertir($listEvaluadores) }})">Comprobar Existencia</button>
                            </div>
                            <div>
                                {!! $errors->first('adm-meritos-ci', '<strong class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="d-none text-center" id="ci-no-existe">
                            <strong class="text-danger">El CI ingresado ya exite</strong>
                        </div>
                        <div class="d-none text-center" id="ci-existe">
                            <strong class="text-success">El CI ingresado aun no existe</strong>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-nombre">Nombre:</label>
                            <input type="text" class="form-control" name="adm-meritos-nombre" id="adm-meritos-nombre"
                                placeholder="Ingrese el nombre(s)" required minlength="3"
                                value="{{ old('adm-meritos-nombre') }}">
                            <div>
                                {!! $errors->first('adm-meritos-nombre', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-apellidos">Apellidos</label>
                            <input type="text" class="form-control" name="adm-meritos-apellidos" id="adm-meritos-apellidos"
                                placeholder="Ingrese los apellidos" required minlength="3"
                                value="{{ old('adm-meritos-apellidos') }}">
                            <div>
                                {!! $errors->first('adm-meritos-apellidos', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-correo">Correo:</label>
                            <input type="email" class="form-control" name="adm-meritos-correo" id="adm-meritos-correo"
                                placeholder="Ingrese el correo electronico" required
                                value="{{ old('adm-meritos-correo') }}">
                            <div>
                                {!! $errors->first('adm-meritos-correo', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-correo-alter">Correo alternativo:</label>
                            <input type="email" class="form-control" name="adm-meritos-correo-alter" id="adm-meritos-correo-alter"
                                placeholder="Ingrese el correo electronico alternativo" required
                                value="{{ old('adm-meritos-correo-alter') }}">
                            <div>
                                {!! $errors->first('adm-meritos-correo-alter', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        
                        @if($errors->any())
                            <script>
                                window.onload = () => {
                                    $('#modalCrearEvaluadorMerit').modal('show');
                                }
                            </script>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-secondary" value="Cancelar" data-dismiss="modal">
                    <input type="submit" class="btn btn-info" value="Guardar" form="form-create-evaluador-merito">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Actualizar evaluador de meritos --}}
    <div class="modal fade" id="modalUpdateEvaluadorMerit" tabindex="-1" role="dialog"
        aria-labelledby="importanDatesTitleUpdate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importanDatesTitleUpdate">Editar evaluador de méritos</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admMeritosUpdate') }}"
                        id="form-update-evaluador-merito">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" id="id-dato-edit" name="id-dato-edit">

                        <div class="form-group">
                            <label for="adm-meritos-ci-edit">CI:</label>
                            <input type="number" class="form-control" name="adm-meritos-ci-edit" id="adm-meritos-ci-edit"
                                placeholder="Ingrese el número de carnet" required minlength="4" maxlength="10"
                                value="{{ old('adm-meritos-ci-edit') }}">
                            <div>
                                {!! $errors->first('adm-meritos-ci-edit', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-nombre-edit">Nombre:</label>
                            <input type="text" class="form-control" name="adm-meritos-nombre-edit" id="adm-meritos-nombre-edit"
                                placeholder="Ingrese el nombre(s)" required minlength="3"
                                value="{{ old('adm-meritos-nombre-edit') }}">
                            <div>
                                {!! $errors->first('adm-meritos-nombre-edit', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-apellidos-edit">Apellidos</label>
                            <input type="text" class="form-control" name="adm-meritos-apellidos-edit" id="adm-meritos-apellidos-edit"
                                placeholder="Ingrese los apellidos" required minlength="3"
                                value="{{ old('adm-meritos-apellidos-edit') }}">
                            <div>
                                {!! $errors->first('adm-meritos-apellidos-edit', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-correo-edit">Correo:</label>
                            <input type="email" class="form-control" name="adm-meritos-correo-edit" id="adm-meritos-correo-edit"
                                placeholder="Ingrese el correo electronico" required 
                                value="{{ old('adm-meritos-correo-edit') }}">
                            <div>
                                {!! $errors->first('adm-meritos-correo-edit', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adm-meritos-correo-alter-edit">Correo alternativo:</label>
                            <input type="email" class="form-control" name="adm-meritos-correo-alter-edit" id="adm-meritos-correo-alter-edit"
                                placeholder="Ingrese el correo electronico alternativo" required 
                                value="{{ old('adm-meritos-correo-alter-edit') }}">
                            <div>
                                {!! $errors->first('adm-meritos-correo-alter-edit', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        @if ($errors->has('adm-meritos-ci-edit')||$errors->has('adm-meritos-nombre-edit')||
                             $errors->has('adm-meritos-apellidos-edit')||$errors->has('adm-meritos-correo-edit')||
                             $errors->has('adm-meritos-correo-alter-edit'))
                            <script>
                                window.onload = () => {
                                    $('#modalUpdateEvaluadorMerit').modal('show');
                                }
                            </script>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="form-update-evaluador-merito">
                </div>
            </div>
        </div>
    </div>

    @php
        function convertir($object) {
        return json_encode($object);
        }
    @endphp




</div>
    
@endsection