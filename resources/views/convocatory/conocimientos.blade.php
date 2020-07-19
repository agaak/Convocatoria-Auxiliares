@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3>Sección Calificación de Conocimientos</h3>

  <div class="card border-dark mb-3 {{session()->get('ver')? 'my-4': ''}}">
    <div class="card-body">
      <p class="card-text">La calificación de conocimientos se realiza sobre la base de <strong> 100 </strong> puntos,
        equivalentes al <strong> {{ $porcentajesConvocatoria->porcentaje_conocimiento??"_ _ _" }}% </strong>
        de la calificación final.</p>
    </div>
  </div>



  {{-- Visualizar Tabla de estructura de conocimientos --}}
  @component('components.convocatoria.tablaConocimientos', 
    ['list_aux' => $list_aux,'tems' => $tems,'porcentajes' => $porcentajes,'areas' => $areas,'tematics' => $tematics])
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
            @if($list_aux->isNotEmpty())
            <div class="form-group">
              @if($tematics->isEmpty())
                <label for="nombre">No hay tematicas para añadir</label>
              @else
                <label for="nombre">Nombre de la Tematica</label>
                <input type="hidden" id="id-auxiliatura" name="id-auxiliatura">
                <select class="form-control" id="id-tematica" name="id-tematica" onclick="select_tem({{json_encode($areas)}})">
                    {{-- <option value={{ $tematic->id }}>{{ $tematic->nombre }}</option> --}}
                </select>
                <div class="form-row">
                  <label class="col-sm-6 col-form-label text-center">Area de Evaluacion</label>
                  <label class="col-sm-5 col-form-label text-center">Porcentaje</label>
                </div>
                  @foreach($areas as $area)
                  <div class="form-row col-sm-12 mt-2">
                    <div class="form-check col-sm-6 mx-3">
                      <input class="form-check-input" onclick="check({{ $area->id }})" type="checkbox" 
                          value="{{ $area->id }}" name="area[]" id="{{ $area->id }}-check">
                      <label class="form-check-label" for="{{ $area->id }}-check">
                        {{ $area->nombre }}
                      </label>
                    </div>
                    <div class="col-sm-3 mx-2">
                    <input type="number" class="form-control form-control-sm text-center"
                        name="area-aux[]" min="1" max="100" disabled required id=".{{ $area->id }}">
                      </div>
                  </div>
                  @endforeach
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
            action="{{ route('knowledgeRatingTematicUpdate') }}"
            role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="id-tematica-edit" name="id-tematica-edit">
            <input type="hidden" id="id-auxiliatura-edit" name="id-auxiliatura-edit">
            <div class="form-group">
              @if($tematics->isEmpty())
                <label for="nombre">No hay tematicas para cambiar</label>
              @else
                <label for="nombre">Nombre de la Tematica</label>
                <select class="form-control" id="nombre-tem-edit" name="nombre-tem-edit"></select>
                <div class="form-row">
                  <label class="col-sm-6 col-form-label text-center">Area de Evaluacion</label>
                  <label class="col-sm-5 col-form-label text-center">Porcentaje</label>
                </div>
                  @foreach($areas as $area)
                  <div class="form-row col-sm-12 mt-2">
                    <div class="form-check col-sm-6 mx-3">
                      <input class="form-check-input" onclick="check2({{ $area->id }})" type="checkbox" 
                          name="id-area-edit[]" id="{{ $area->id }}-edit" autocomplete="off">
                      <label class="form-check-label" for="{{ $area->id }}-edit">{{ $area->nombre }}</label>
                    </div>
                    <div class="col-sm-3 mx-2">
                    <input type="number" class="form-control form-control-sm text-center" autocomplete="off"
                        name="porc-edit[]" min="1" max="100" disabled required id=".{{ $area->id }}-edit">
                      </div>
                  </div>
                  @endforeach
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
  function check(id) {
    var estado = document.getElementById('.'+id).disabled;
    document.getElementById('.'+id).disabled = !estado;
    document.getElementById('.'+id).value = "";
  }
  function select_tem(areas){
    areas.forEach(area => {
      document.getElementById('.'+area['id']).value = "";
      document.getElementById('.'+area['id']).disabled = true;
      document.getElementById(area['id']+'-check').checked = false;

    });
  }
  function check2(id) {
    var estado = document.getElementById('.'+id+'-edit').disabled;
    document.getElementById('.'+id+'-edit').disabled = !estado;
    document.getElementById('.'+id+'-edit').value = "";
  }
</script>
@endsection