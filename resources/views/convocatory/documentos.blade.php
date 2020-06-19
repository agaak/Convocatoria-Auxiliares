@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase text-left">Documentos</h3>

  <!-- Button trigger modal -->
  @if (!session()->get('ver'))    
    <div class="my-3" style="margin-left: 3ch">
      <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#documentosModal">
        <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
        <span class="mx-1">Añadir documento</span>
      </a>
    </div>
  @endif
  {{-- Visualizar Tabla de documentos --}}
  @php  $alphas = 65  @endphp
  @component('components.convocatoria.tablaDocumentos', 
    ['documentos' => $documentos,'alphas' => $alphas])
  @endcomponent
  
  <div class="table-requests">
    <form method="POST" class="my-5" action="{{ route('docNota') }}">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="nota-doc">Nota(*)</label>
        @if (!session()->get('ver'))
          <input class="btn btn-info btn-sm mx-3" type="submit" value="Guardar nota">
        @endif
        <textarea class="form-control my-2" id="nota-doc" name="nota-doc" 
        placeholder="Ingrese la nota respectiva" {{ session()->get('ver')? 'readonly': '' }}
        rows="3">{{ $datoNotaDoc === null? '': $datoNotaDoc->descripcion }}</textarea>
      </div>
    </form>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="documentosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Documento</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" accion="{{ route('documentoValid') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="exampleInputEmail1">Documento {{ chr($alphas) }}:
              </label>
              <textarea class="form-control" id="descripcion-req" placeholder="Especifique el documento"
                rows="3" name="descripcion"  minlength="11" required></textarea>
            </div>
            {!! $errors->first('descripcion', '<strong class="message-error text-danger">:message</strong>') !!}
            @if ($errors->has('descripcion'))
              <script>
                  window.onload = () => {
                      $('#documentosModal').modal('show');
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
  <div class="modal fade" id="requirementsEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Requisito</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('documentoUpdate') }}" role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="id-requirement" name="id-requirement">
            <div class="form-group">
              <label for="exampleInputEmail1">Inciso</label>
              <label for="exampleInputEmail1" id="inc-req-edit" name="inc-req-edit"></label>
              <textarea class="form-control" id="descripcion-requirement" minlength="11" required
                rows="3" name="descripcion-edit">{{ old('descripcion-edit') }}</textarea>
              <small id="emailHelp" class="form-text text-muted">Los documentos se listan en orden alfabético.</small>
            </div>
            {!! $errors->first('descripcion-edit', '<strong class="message-error text-danger">:message</strong>') !!}
            @if ($errors->has('descripcion-edit'))
              <script>
                  window.onload = () => {
                      $('#requirementsEditModal').modal('show');
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


</div>
@endsection