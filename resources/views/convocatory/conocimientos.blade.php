@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase">Calificacion de Conocimientos</h3>

  <div class="card border-dark mb-3 {{session()->get('ver')? 'my-4': ''}}">
    <div class="card-body">
      <p class="card-text">La calificación de conocimientos se realiza sobre la base de <strong> 100 </strong> puntos,
        equivalentes al <strong> {{ $porcentajesConvocatoria->porcentaje_conocimiento??"_ _ _" }}% </strong>
        de la calificación final.</p>
    </div>
  </div>

  <!-- Button trigger modal -->
  @if (!session()->get('ver'))
    <div class="row my-3" style="margin-left: 3ch">
      <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#tematicaModal">
        <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
        <span class="mx-1">Añadir Tematica</span>
      </a>
      <a class="text-decoration-none" style="margin-left: 15px" type="button" data-toggle="modal"
        data-target="#auxiliaturaModal"
        @if($requests->isNotEmpty()) onclick="selectAuxiliaturaModal({{ json_encode($porcentajes) }}, {{ json_encode($tems) }})" @endif>
        <img src="{{ asset('img/pen.png') }}" width="30" height="30">
        <span class="mx-1">Editar Auxiliatura</span>
      </a>
    </div>  
  @endif

  {{-- Visualizar Tabla de estructura de conocimientos --}}
  @component('components.convocatoria.tablaConocimientos', 
    ['requests' => $requests,'tems' => $tems,'porcentajes' => $porcentajes])
  @endcomponent
  
  <!-- Modal Tematica-->
  <div class="modal fade" id="tematicaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tematica</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('knowledgeRatingTematicValid') }}">
            {{ csrf_field() }}
            @if($requests->isNotEmpty())
            <div class="form-group">
              @if($tematics->isEmpty())
                <label for="nombre">No hay tematicas para añadir</label>
              @else
                <label for="nombre">Nombre de la Tematica</label>
                <select class="form-control" id="id-tematica" name="id-tematica">
                  @foreach($tematics as $tematic)
                    <option value={{ $tematic->id }}>{{ $tematic->nombre }}</option>
                  @endforeach
                </select>
              @endif
            </div>
            @endif
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              {{-- <input class="btn btn-info" type="submit" value="Guardar"> --}}
              @if($tematics->isEmpty())
                <input class="btn btn-info" type="submit" value="Guardar" disabled>
              @else
                <input class="btn btn-info" type="submit" value="Guardar">
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Auxiliatura-->
  <div class="modal fade" id="auxiliaturaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Auxiliatura</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('knowledgeRatingAuxUpdate') }}" role="form">
            {{ csrf_field() }}
            @if($requests->isNotEmpty())
            <div class="form-group">
              <div class="form-row" style="margin-bottom: 5px">
                <label class="col-auto col-form-label" for="department-conv">Auxiliatura</label>
                <div class="col-xl">
                  <select onchange="selectAuxiliaturaModal({{ json_encode($porcentajes) }}, {{ json_encode($tems) }})"
                    class="form-control" id="id-req" name="id-req">
                    @foreach($requests as $item)
                      <option value="{{ $item->id }}">{{ $item->cod_aux }} - {{ $item->nombre_aux }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div style="visibility: hidden"> {{ $num = 1 }}</div>
              @foreach($tems as $tematic)
                <input type="hidden" name="id-tem[]" value="{{ $tematic->id }}">
                <div class="form-row">
                  <div class="form-group col-7">
                    <div class="row">
                      <label class="col-sm-5 col-form-label">Tematica
                        {{ $num++ }}{{ ":" }}</label>
                      <label class="col-sm-7 col-form-label"><span style="font-weight: normal;">{{ $tematic->nombre }}
                        </span></label>
                    </div>
                  </div>
                  <div class="form-group col-4">
                    <div class="row">
                      <label class="col-sm-7 col-form-label" for="porcent-merit">Porcentaje:</label>
                      <input type="number" class="form-control form-control-sm col-sm-5 porcentaje-aux"
                        name="porcentaje-aux[]" min="0" max="100" required>

                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            @endif
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <input class="btn btn-info" type="submit" value="Guardar">
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Edit Tematica-->
  <div class="modal fade" id="tematicaEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tematica</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST"
            action="{{ route('knowledgeRatingTematicUpdate','2' ) }}"
            role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="id-tematica-edit" name="id-tematica-edit">
            <div class="form-group">
              @if($tematics->isEmpty())
                <label for="nombre">No hay tematicas para cambiar</label>
              @else
                <label for="nombre">Nombre de la Tematica</label>
                <select class="form-control" id="nombre-tem" name="nombre-tem">
                  @foreach($tematics as $tematic)
                    <option value={{ $tematic->id }}>{{ $tematic->nombre }}</option>
                  @endforeach
                </select>
              @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <input class="btn btn-info" type="submit" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @if (!session()->get('ver'))
    <div class="my-4 py-5 text-center">
      {!! $errors->first('finalizo', '<strong class="message-error text-danger">:message</strong>') !!}
      <form action="{{ route('knowledgeRatingFinish') }}" enctype="multipart/form-data" method="POST" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="custom-file col-sm-4" lang="es">
          @if ($rutaPDF === null)
            <input type="file" class="custom-file-input" id="upload-pdf" name="upload-pdf" lang="es" required>
            <label class="custom-file-label" style="text-align: left;" for="customFileLang">Seleccionar PDF</label>
          @endif
          <input type="hidden" name="finalizo" value=""> 
        </div><br>
        <button type="submit" class="btn btn-info mt-3" tabindex="-1" role="button" aria-disabled="true">
          Finalizar
        </button>
      </form>
    </div>
  @endif
</div>
<script>

</script>
@endsection