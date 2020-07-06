@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')

  <div class="overflow-auto content">

  <h3>Avisos</h3>
  <!-- Button trigger modal -->
  <div class="row mr-1 ml-1">
    <button type="button" class="btn btn-dark my-3 col-xs-2" data-toggle="modal" 
    data-target="#avisosModal">Registrar aviso</button>
  </div>
  {{-- Visualizar Tabla de avisos --}}
  @component('components.admConvocatoria.tablaAvisos', 
    ['listAvisos' => $listAvisos])
  @endcomponent

  <!-- Modal -->
  <div class="modal fade" id="avisosModal" tabindex="-1" role="dialog" 
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Registrar aviso</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" accion="{{ route('admAvisos.create') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="avisoTitulo">Titulo</label>
              <textarea class="form-control" id="avisoTitulo" placeholder="Especifique el titulo del aviso"
                rows="2" name="avisoTitulo"  minlength="10" required>{{ old('avisoTitulo') }}</textarea>
            </div>
            {!! $errors->first('avisoTitulo', '<strong class="message-error text-danger">:message</strong>') !!}
            @if ($errors->has('avisoTitulo'))
              <script>
                  window.onload = () => {
                      $('#avisosModal').modal('show');
                  }
              </script>
            @endif
            <div class="form-group">
              <label for="exampleInputEmail1">Descripcion</label>
              <textarea class="form-control" id="avisoDescripcion" placeholder="Especifique la descripcion del aviso"
                rows="3" name="avisoDescripcion"  minlength="20" required>{{ old('avisoDescripcion') }}</textarea>
            </div>
            {!! $errors->first('descripcion', '<strong class="message-error text-danger">:message</strong>') !!}
            @if ($errors->has('descripcion'))
              <script>
                  window.onload = () => {
                      $('#avisosModal').modal('show');
                  }
              </script>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <input class="btn btn-info" type="submit" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal Edit-->
  <div class="modal fade" id="modalUpdateAviso" tabindex="-1" role="dialog" 
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Editar aviso</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('admAvisos.update') }}" role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="idAvisoEdit" name="idAvisoEdit">
            <div class="form-group">
              <label for="avisoTituloEdit">Titulo</label>
              <textarea class="form-control" id="avisoTituloEdit" minlength="10" required
                placeholder="Especifique el titulo del aviso" rows="2" 
                name="avisoTituloEdit">{{ old('avisoTituloEdit') }}</textarea>
            </div>
            {!! $errors->first('avisoTituloEdit', '<strong class="message-error text-danger">:message</strong>') !!}
            @if ($errors->has('avisoTituloEdit'))
            <script>
              window.onload = () => {
                $('#modalUpdateAviso').modal('show');}
            </script>
            @endif
            <div class="form-group">
              <label for="avisoDescripcionEdit">Descripcion</label>
              <textarea class="form-control" id="avisoDescripcionEdit" minlength="10" required
              placeholder="Especifique la descripcion del aviso"
                rows="3" name="avisoDescripcionEdit">{{ old('avisoDescripcionEdit') }}</textarea>
            </div>
            {!! $errors->first('avisoDescripcionEdit', '<strong class="message-error text-danger">:message</strong>') !!}
            @if ($errors->has('avisoDescripcionEdit'))
            <script>
              window.onload = () => {
                $('#modalUpdateAviso').modal('show');}
            </script>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <input class="btn btn-info" type="submit" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection