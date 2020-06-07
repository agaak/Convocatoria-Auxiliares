@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">

    <h3 class="text-uppercase text-center">Comision de evaluacion de conocimientos</h3>
    <!-- Trigger modal -->
    <button class="pl-4 pr-4 btn btn-dark mt-3" type="button" data-toggle="modal" data-target="#admConoModal">Registrar Evaluador</button>

    <!-- Table -->
    <div class="table-requests1 vertical-align: middle; mt-3">
        <table class="table table-bordered" style="text-align:center">
        <thead class="thead-dark" style="text-align: center">
        <tr>
                @if ($tipoConvocatoria==2)
                <th style="font-weight: normal" scope="col" >Auxiliatura</th>
                @else
                <th style="font-weight: normal" scope="col">Tematica</th>
                @endif 
            <th style="font-weight: normal" scope="col">Carnet</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Correo</th>
            <th style="font-weight: normal" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
        @foreach ($evaluadores as $evaluador)
        @php $num = 1; $tam = 0; @endphp
            <tr>
            @foreach($lista_tem_aux as $tem_aux)
                @php $tem_aux->id_eva == $evaluador->id_eva_conv? $tam++ : $tam; @endphp
                @if($num == 1 && $tem_aux->id_eva == $evaluador->id_eva_conv)
                @php  $num++ @endphp
                <td scope="col" style="text-align: left">{{$tem_aux->nombre}}</td>
                @endif 
            @endforeach
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}" >{{$evaluador->ci}}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}">{{$evaluador->nombre}}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}">{{$evaluador->apellido}}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}">{{$evaluador->correo}}</td>
                <td class="table-light" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                    <a class="options" data-toggle="modal" data-target="#editEvalConociminetos" 
                    onclick="editEvalConociminetos({{ json_encode($evaluador) }}, {{ json_encode($lista_tem_aux) }}, {{ json_encode($listaMultiselect) }})"
                    data-dismiss="modal"><img src="{{ asset('img/pen.png') }}" width="20" height="25"></a>
                    <form class="d-inline" action="{{ route('admConocimientosDelete', $evaluador->id) }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-link">
                        <img src="{{ asset('img/trash.png') }}" width="20" height="25">
                      </button>
                    </form>
                  </td>  
            </tr>
            @foreach ($lista_tem_aux as $tem_aux)
                @if($tem_aux->id_eva==$evaluador->id_eva_conv)
                    @if($num++ > 2)
                        <tr><td scope="col" style="text-align: left">{{$tem_aux->nombre}}</td></tr>
                   @endif
                @endif
            @endforeach        
        @endforeach
        </tbody>
        </table>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    </div>


    

</div>
{{-- Modal para crear nuevo evaluador de conocimientos --}}
<div class="modal fade" id="admConoModal" tabindex="-1" role="dialog" aria-labelledby="admConoModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="admConoModalTitle">Registrar Evaluador de Conocimientos</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admConoStore') }}" id="from-adm-conocimientos">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="adm-cono-tipo">Auxiliatura:</label>
                            <select id="adm-cono-tipo" name="adm-cono-tipo[]" class="select2" multiple="multiple">
                                @foreach ($listaMultiselect as $item)
                                    <option value="{{ $item->id_unico }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('adm-cono-tipo', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-ci">CI:</label>
                            <div class="row m-auto">
                                <input type="number" name="adm-cono-ci" placeholder="Ingrese 76446636 para prueba" class="form-control col-sm-7" id="adm-cono-ci" value="{{ old('adm-cono-ci') }}" required>
                                <button type="button" class="btn btn-primary col-sm-5" onclick="comprobar({{ $listaEva }})">Comprobar Existencia</button>
                            </div>
                            {!! $errors->first('adm-cono-ci', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="d-none text-center" id="ci-no-existe">
                            <strong class="text-danger">El CI ingresado ya exite</strong>
                        </div>
                        <div class="d-none text-center" id="ci-existe">
                            <strong class="text-success">El CI ingresado aun no existe</strong>
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-nombre">Nombre:</label>
                            <input type="text" name="adm-cono-nombre" minlength="3" disabled id="adm-nom" class="form-control" value="{{ old('adm-cono-nombre') }}" required>
                            {!! $errors->first('adm-cono-nombre', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-apellidos">Apellidos:</label>
                            <input type="text" name="adm-cono-apellidos" minlength="3" disabled id="adm-ape" class="form-control" value="{{ old('adm-cono-apellidos') }}" required>
                            {!! $errors->first('adm-cono-apellidos', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                        <label for="adm-cono-correo">Correo:</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control mt-0" name="adm-cono-correo" disabled id="adm-correo" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2" value="{{ old('adm-cono-correo') }}" required>
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@gmail.com</span>
                            </div>
                        </div>
                        {!! $errors->first('adm-cono-correo', '<strong class="message-error text-danger">:message</strong>') !!}<br>
                        <label for="adm-cono-correo">Correo Alternativo:</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="adm-cono-correo2" disabled id="adm-correo2" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2" value="{{ old('adm-cono-correo2') }}" >
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@gmail.com</span>
                            </div>
                        </div>
                        </div>
                        @if ($errors->any())
                            <script>
                                window.onload = () => {
                                    $('#admConoModal').modal('show');
                                }
                            </script>
                        @endif
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="from-adm-conocimientos" class="btn btn-info" id="button-guardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para editar evaluador de conocimientos --}}
<div class="modal fade" id="editEvalConociminetos" tabindex="-1" role="dialog" aria-labelledby="admConoModalTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="admConoModalTitle">Editar Evaluador de Conocimientos</h5>
            <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admConoUpdate') }}" id="from-adm-conocimientos-edit">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" id="id-evaluador" name="id-evaluador">
                <div class="form-group">
                    <label for="adm-cono-tipo">Auxiliatura:</label>
                    <select id="adm-cono-tipo" name="adm-cono-tipo[]" class="select2" multiple="multiple">
                            <option value=""></option>{{--                                                  --}}
                    </select>
                    {!! $errors->first('adm-cono-tipo', '<strong class="message-error text-danger">:message</strong>') !!}
                </div>
                <div class="form-group">
                    <label for="adm-cono-ci">CI:</label>
                    <div class="row m-auto">
                        <input type="number" name="adm-cono-ci-edit" placeholder="Ingrese 76446636 para prueba" class="form-control col-sm-7" id="adm-cono-ci-edit" value="{{ old('adm-cono-ci') }}" required>
                        <button type="button" class="btn btn-primary col-sm-5" onclick="comprobar({{ $listaEva }})">Comprobar Existencia</button>
                    </div>
                    {!! $errors->first('adm-cono-ci', '<strong class="message-error text-danger">:message</strong>') !!}
                </div>
                <div class="d-none text-center" id="ci-no-existe">
                    <strong class="text-danger">El CI ingresado ya exite</strong>
                </div>
                <div class="d-none text-center" id="ci-existe">
                    <strong class="text-success">El CI ingresado aun no existe</strong>
                </div>
                <div class="form-group">
                    <label for="adm-cono-nombre">Nombre:</label>
                    <input type="text" name="adm-cono-nombre-edit" id="adm-cono-nombre-edit" minlength="3" class="form-control" value="{{ old('adm-cono-nombre') }}" required>
                    {!! $errors->first('adm-cono-nombre', '<strong class="message-error text-danger">:message</strong>') !!}
                </div>
                <div class="form-group">
                    <label for="adm-cono-apellidos">Apellidos:</label>
                    <input type="text" name="adm-cono-apellidos-edit" id="adm-cono-apellidos-edit" minlength="3" class="form-control" value="{{ old('adm-cono-apellidos') }}" required>
                    {!! $errors->first('adm-cono-apellidos', '<strong class="message-error text-danger">:message</strong>') !!}
                </div>
                <div class="form-group">
                    <label for="adm-cono-correo">Correo:</label>
                    <input type="email" name="adm-cono-correo-edit" id="adm-cono-correo-edit" class="form-control" value="{{ old('adm-cono-correo') }}" required>
                    {!! $errors->first('adm-cono-correo', '<strong class="message-error text-danger">:message</strong>') !!}
                </div>
                @if ($errors->any())
                    <script>
                        window.onload = () => {
                            $('#admConoModal').modal('show');
                        }
                    </script>
                @endif
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" form="from-adm-conocimientos-edit" class="btn btn-info" id="button-guardar">Guardar</button>
        </div>
    </div>
</div>
</div>

    
@endsection