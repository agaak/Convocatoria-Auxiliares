@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase">Calificacion de Conocimientos</h3>

  <div class="card border-dark mb-3">
    <div class="card-body">
      <p class="card-text">La calificación de conocimientos se realiza sobre la base de <strong> 100 </strong> puntos,
        equivalentes al <strong> 80% </strong>
        de la calificación final.</p>
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row my-3" style="margin-left: 3ch">
    <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#tematicaModal">
      <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
      <span class="mx-1">Añadir Tematica</span>
    </a>
    <a class="text-decoration-none" style="margin-left: 15px" type="button" data-toggle="modal"
      data-target="#auxiliaturaModal"
      onclick="selectAuxiliaturaModal({{ json_encode($porcentajes) }}, {{ json_encode($tems) }})">
      <img src="{{ asset('img/pen.png') }}" width="30" height="30">
      <span class="mx-1">Editar Auxiliatura</span>
    </a>
  </div>

  <!-- Table -->
  <div class="table-requests">
    <table class="table table-bordered" style="text-align: center">
      <thead class="thead-dark">
        <tr>
          <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">#</th>
          <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Tematica</th>
          <th style="font-weight: normal" scope="col" colspan="{{ count($requests) }}">Codigo de Auxiliatura</th>
          <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Opciones de<br>Tematica </th>
        </tr>
        <tr>
          @foreach($requests as $item)
            <th style="font-weight: normal" scope="col">{{ $item->cod_aux }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @php $num = 1  @endphp
        @foreach($tems as $tematic)
          <tr>
            <td class="table-light">{{ $num++ }}</td>
            <td class="table-light">{{ $tematic->nombre }}</td>
            @foreach($porcentajes as $item)
              @if($item->id_tematica == $tematic->id)
                <td class="table-light">{{ $item->porcentaje }}</td>
              @endif
            @endforeach
            <td class="table-light">
              <a class="options" data-toggle="modal" data-target="#tematicaEditModal" data-id="{{ $tematic->id }}"
                data-nombre="{{ $tematic->nombre }}" data-dismiss="modal"><img
                  src="{{ asset('img/pen.png') }}" width="25" height="25"></a>
              <form class="d-inline"
                action="{{ route('knowledgeRatingTematicDelete', $tematic->id) }}"
                method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-link">
                  <img src="{{ asset('img/trash.png') }}" width="25" height="25">
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
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
                <div class="form-row " style="margin-top: 20px">
                  <div class="form-group col-6">
                    <div class="row">
                      <label class="col-8 col-form-label" for="porcent-merit">Valor por defecto:</label>
                      <input type="number" class="form-control col-sm-4" name="porcentaje" id="porcentaje" value="30"
                        min="0" max="100" required>
                    </div>
                  </div>
                </div>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <input class="btn btn-info" type="submit" value="Guardar">
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

  <div class="my-4 py-5 text-center">
    <form action="{{ route('knowledgeRatingFinish') }}" enctype="multipart/form-data" method="POST" accept-charset="UTF-8">
      {{ csrf_field() }}
      <div class="custom-file col-sm-4" lang="es">
        <input type="file" class="custom-file-input" id="upload-pdf" name="upload-pdf" lang="es" required>
        <label class="custom-file-label" style="text-align: left;" for="customFileLang">Seleccionar PDF</label>
      </div><br>
      <button type="submit" class="btn btn-info mx-3 mt-3" tabindex="-1" role="button" aria-disabled="true">
        Finalizar
      </button>
    </form>
  </div>
</div>
<script>

</script>
@endsection