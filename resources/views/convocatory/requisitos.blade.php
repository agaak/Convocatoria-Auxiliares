@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase text-left">Seccion Requisitos</h3>

  <!-- Button trigger modal -->
  <div class="my-3" style="margin-left: 3ch">
    <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#requirementsModal">
      <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
      <span class="mx-1">Añadir requisito</span>
    </a>
  </div>

  <div class="table-requests">
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th style="font-weight: normal" scope="col">#</th>
          <th style="font-weight: normal" scope="col">Descripcion</th>
          <th style="font-weight: normal" scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody style="background-color: white">
        <div style="visibility: hidden"> {{ $alphas = 65 }}</div> 
        @foreach($requerimients as $requeriment)
        <tr>
          <th scope="row">{{ chr($alphas++) }} )</th>
          <td style="text-align: justify;">
            {{ $requeriment->descripcion }}
          </td>
          <td style="text-align: center">
            <a class="options" data-toggle="modal" data-target="#requirementsEditModal" data-id="{{ $requeriment->id }}"
              data-descripcion="{{ $requeriment->descripcion }}"  data-inc="{{ chr($alphas-1) }}" data-dismiss="modal"><img
                src="{{ asset('img/pen.png') }}" width="25" height="25"></a>
                  
                <form class="d-inline" action="{{ route('requirementDelete', $requeriment->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-link">
                      <img src="{{ asset('img/trash.png') }}" width="25" height="25">
                  </button>    
              </form>
          </td>
        </tr>@endforeach
      </tbody>
    </table>
    <form method="post" accion=>
      <div class="form-group">
        <label for="exampleInputEmail1">Nota(*)</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="" placeholder="Ingrese la nota respectiva"
          rows="3"></textarea>
      </div>
    </form>
    <div class="my-5 py-5 text-center">
      <a href="{{ route('requests') }}" class="btn btn-info" tabindex="-1" role="button"
      aria-disabled="true">Anterior</a>
      <a href="{{ route('documentos') }}" class="btn btn-info" tabindex="-1" role="button"
        aria-disabled="true">Siguiente</a>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="requirementsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
          <form method="post" accion="{{ route('requirementValid') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="exampleInputEmail1">Inciso {{ chr($alphas) }}:
              </label>
              <textarea class="form-control" id="descripcion-req" placeholder="Ingrese el requisito"
                rows="3" name="descripcion" minlength="11" required></textarea>
              <small id="emailHelp" class="form-text text-muted">Los requisitos se listan en orden alfabético.</small>
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
          <form method="POST" action="{{ route('requirementUpdate') }}" role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="id-requirement" name="id-requirement">
            <div class="form-group">
              <label for="exampleInputEmail1">Inciso</label>
              <input for="exampleInputEmail1" type="button" class="btn btn-light" id="inc-requirement" name="inc-requirement" readonly/>
              <textarea class="form-control" id="descripcion-requirement"
                rows="3" name="descripcion-requirement" value="{{ old('nombre') }}" ></textarea>
              <small id="emailHelp" class="form-text text-muted">Los requisitos se listan en orden alfabético.</small>
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


</div>
@endsection