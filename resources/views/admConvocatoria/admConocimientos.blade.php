@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">

    <h3 class="text-uppercase text-center">Comision de evaluacion de conocimientos</h3>
    <!-- Trigger modal -->
    <button class="pl-4 pr-4 btn btn-dark" type="button" data-toggle="modal" data-target="#admConoModal">Registrar Evaluador</button>

    <!-- Table -->
    <div class="table-requests1">
        <table class="table table-bordered" style="text-align:Left"  >
        <thead class="thead-dark">
            <tr>
                @if (2==2)
                <th style="font-weight: normal" scope="col" >Cod.Aux</th>
                @else
                <th style="font-weight: normal" scope="col">Tematica</th>
                @endif 
            <th style="font-weight: normal" scope="col">CI</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Email</th>
            <th style="font-weight: normal" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
            <div style="visibility: hidden"> {{ $num = 1 }}</div>
            <tr>
            <td scope="col">Introd1</td>
            
            <td scope="col" rowspan="3">9999999</td>
            <td scope="col" rowspan="3">Constantine Bennedict </td>
            <td scope="col" rowspan="3">Papadopolis Vasilievich</td>
            <td scope="col" rowspan="3">correocreadfullpro@hotmail.com</td>
                <td class="table-light" scope="col" rowspan="3">
                    <a class="options" data-toggle="modal" data-target="#tematicaEditModal" 
                    data-dismiss="modal"><img src="{{ asset('img/pen.png') }}" width="20" height="25"></a>
                    <form class="d-inline"
                      action="#"
                      method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-link">
                        <img src="{{ asset('img/trash.png') }}" width="20" height="25">
                      </button>
                    </form>
                  </td>  
            </tr>
            <tr><td scope="col">Introd1</td></tr>
            <tr><td scope="col">Introd1</td></tr>
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
                                <button type="button" class="btn btn-primary col-sm-5" onclick="comprobar({{ $listaCi }})">Comprobar Existencia</button>
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
                            <input type="text" name="adm-cono-nombre" minlength="3" class="form-control" value="{{ old('adm-cono-nombre') }}" required>
                            {!! $errors->first('adm-cono-nombre', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-apellidos">Apellidos:</label>
                            <input type="text" name="adm-cono-apellidos" minlength="3" class="form-control" value="{{ old('adm-cono-apellidos') }}" required>
                            {!! $errors->first('adm-cono-apellidos', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-correo">Correo:</label>
                            <input type="email" name="adm-cono-correo" class="form-control" value="{{ old('adm-cono-correo') }}" required>
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
                    <button type="submit" form="from-adm-conocimientos" class="btn btn-info" id="button-guardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection