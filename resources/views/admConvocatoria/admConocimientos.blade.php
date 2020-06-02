@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <button class="pl-4 pr-4 btn btn-dark" type="button" data-toggle="modal" data-target="#admConoModal">Registrar Evaluador</button>
</div>

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
                                <option value="dato1">DATO 1</option>
                                <option value="dato2">DATO 2</option>
                                <option value="dato3">DATO 3</option>
                                <option value="dato4">DATO 4</option>
                                <option value="dato5">DATO 5</option>
                                <option value="dato6">DATO 6</option>
                                <option value="dato7">DATO 7</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-ci">CI:</label>
                            <div class="row m-auto">
                                <input type="number" name="adm-cono-ci" placeholder="Ingrese 76446636 para prueba" class="form-control col-sm-7" id="adm-cono-ci" value="{{ old('adm-cono-ci') }}" required>
                                <button type="button" class="btn btn-primary col-sm-5" id="adm-cono-btn">Comprobar Existencia</button>
                            </div>
                        </div>
                        <div class="d-none text-center" id="ci-no-existe">
                            <strong class="text-danger">El CI ingresado ya exite</strong>
                        </div>
                        <div class="d-none text-center" id="ci-existe">
                            <strong class="text-success">El CI ingresado aun no existe</strong>
                        </div>
                        {{ $errors->first('adm-cono-ci') }}
                        <div class="form-group">
                            <label for="adm-cono-nombre">Nombre:</label>
                            <input type="text" name="adm-cono-nombre" class="form-control" value="{{ old('adm-cono-nombre') }}" required>
                        </div>
                        {{ $errors->first('adm-cono-nombre') }}
                        <div class="form-group">
                            <label for="adm-cono-apellidos">Apellidos:</label>
                            <input type="text" name="adm-cono-apellidos" class="form-control" value="{{ old('adm-cono-apellidos') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="adm-cono-correo">Correo:</label>
                            <input type="email" name="adm-cono-correo" class="form-control" value="{{ old('adm-cono-correo') }}" required>
                        </div>
                        {{ $errors->first('adm-cono-correo') }}
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