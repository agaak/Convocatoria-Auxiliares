@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

<div class="overflow-auto content">
  <h3>Asignacion de Auxiliaturas</h3>
  <div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      @php $initTabs = true @endphp
      @foreach ($listaAux as $auxiliatura)
          <li class="nav-item">
            <a class="nav-link{{ $initTabs ? " active" : '' }}" id={{ $auxiliatura->id }} data-toggle="tab" 
              href="#{{ "body".$auxiliatura->id }}" role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
              {{ $auxiliatura->nombre_aux }}
            </a>
          </li>
          {{ $initTabs = false  }}
          @endforeach
    </ul>
    @php $initContent = true; @endphp
    <div class="tab-content" id="myTabContent">
      @foreach ($listaAux as $auxiliatura)
        <div class="tab-pane fade{{ $initContent ? " show active" : '' }}" id={{ "body".$auxiliatura->id}} 
          role="tabpanel" aria-labelledby={{ $auxiliatura->id}}>
          <h6 class="my-3">Total de auxiliaturas requeridas: {{ $auxiliatura->cant_aux}}</h6>
            <div class="table-requests1">
              <table id= "notas{{ $auxiliatura->id}}" class="table table-striped table-bordered">
                <thead class="thead-dark text-center">
                  <tr>
                    <th class="font-weight-normal" scope="col">#</th>
                    <th class="font-weight-normal" scope="col">CI</th>
                    <th class="font-weight-normal" scope="col">Apellidos</th>
                    <th class="font-weight-normal" scope="col">Nombres</th>
                    <th class="font-weight-normal" scope="col">Nota final</th>
                    <th class="font-weight-normal" scope="col">Cantidad Auxiliaturas</th>
                    <th class="font-weight-normal" scope="col">Asignar</th>
                  </tr>
                </thead>
                <script>
                  function mensaje(){
                    alert('esta seguro de quitar el item'); 
                  }
                </script>
                <tbody style="vertical-align: middle;">
                    @php $num=1; @endphp
                  @if($listaPost->has($auxiliatura->id))
                    @foreach ($listaPost[$auxiliatura->id] as $item)
                      <tr class="table-light">
                        <td class="text-center" style="vertical-align: middle;">{{ $num++ }}</td>
                        <td class="text-center" style="vertical-align: middle;">{{ $item->ci }}</td>
                        <td style="vertical-align: middle;">{{ $item->apellido }}</td>
                        <td style="vertical-align: middle;">{{ $item->nombre }}</td>
                        <td style="vertical-align: middle;" class="text-center">{{ $item->calificacion }}</td>
                        <th style="vertical-align: middle;" class="text-center">
                          @if($item->item===null)
                              {{ "-" }}
                            @elseif($item->item===0)
                              {{"Dado de baja"}} 
                            @else
                              {{ $item->item }}
                            @endif
                        </th>
                        <td class="text-center">
                          <form class="d-inline" action="{{ route('asignar') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" value="{{ $item->id }}" readonly>
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura }}" readonly>
                              <button type="submit" class="btn btn-link">
                                <img src="{{ asset('img/add512.png') }}" width="30" height="32">
                              </button>
                            </form>
                            <form class="d-inline" action="{{ route('quitar') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" value="{{ $item->id }}" readonly>
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura }}" readonly>
                              <button type="submit" class="btn btn-link">
                                <img src="{{ asset('img/minus512.png') }}" width="30" height="32" onclick="mensaje()">
                              </button>
                            </form>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>   
              </table>
              @if (!$finalizado)
              <div class="container text-right">
                <button type="button" class="btn btn-dark my-3 col-xs-2" data-toggle="modal" 
                        data-target="#invitarPostulanteModal" data-asig_id_auxiliatura="{{ $auxiliatura->id}}">Invitar postulante</button>
              </div>
              @endif
            </div>
        </div>
          
        {{ $initContent = false  }}
        @endforeach
    </div>
    @if ($finalizado)
      <div style="text-align: right">
        <button type="button" class="btn btn-secondary">
          <a href="/convocatoria/adm-asignaciones/pdf" style="color: #FFFF;">PDF</a>
        </button>
      </div>
    @endif
</div>



{{-- Modal invitar postulante--}}
<div class="modal fade" id="invitarPostulanteModal" tabindex="-1" role="dialog" aria-labelledby="postModalTitle"
  aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="postModalTitle">Invitar Postulante</h5>
                  <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('admPostulanteInvitar') }}" id="form-create-postulante">
                  {{ csrf_field() }}
                  <input type="hidden" name="asig_id_auxiliatura" id="asig_id_auxiliatura">
                  <input type="hidden" name="post-id" id="post-id">
                    <div class="form-group row pr-0 mb-3">
                      <div class="col-auto">
                        <label for="adm-post-rotulo"  class="col-form-label col-form-label">Carnet:</label>
                      </div>
                      <div class="col-4 px-0">
                        <input type="text" name="adm-post-ci" placeholder="Ingrese su carnet" class="form-control form-control" id="adm-post-ci" required>
                      </div> <div class="col-auto">
                      <button type="button" class="btn btn-primary" onclick="comprobarInvitado({{ $listaPostInvitados }})" >Comprobar Postulante</button>
                    </div>
                      {!! $errors->first('adm-post-ci', '<div class="error" id="err"> <strong class="message-error text-danger col-sm-12">:message</strong></div>') !!}
                      </div>
                      {!! $errors->first('ci', '<div class="error" id="err"> <strong class="message-error text-danger col-sm-12">:message</strong></div>') !!}
                      <div class="d-none text-left col-sm-12 mt-0" id="rotulo-no-existe">
                          <strong class="text-primary">El carnet ingresado existe</strong>
                      </div>
                      <div class="d-none text-left col-sm-12 mt-0" id="rotulo-existe">
                          <strong class="text-danger">El carnet ingresado no existe</strong>
                      </div>                        
                      <div class="form-group row">
                          <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Nombres:</label>
                          <div class="col-sm-9">
                          <input type="text" name="postulante-nombre" readonly id="post-nom" class="form-control" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Apellidos:</label>
                          <div class="col-sm-9">
                              <input class="form-control" type="text" readonly id="post-ape" name="postulante-apellidos" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Nota final:</label>
                          <div class="col-sm-9">
                              <input class="form-control" type="text" readonly id="post-nota" name="post-nota" required readonly>
                          </div>
                      </div>
                </form>
              </div>
              @if($errors->any())
                              <script>
                                  window.onload = () => {
                                      $('#storePostulanteModal').modal('show');
                                  }
                              </script>
              @endif
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-info" form="form-create-postulante" id="bttn-post" disabled>Guardar</button>
              </div>
          </div>
      </div>
  </div>
  <div class="text-center mt-5">
    <form method="POST" action="{{ route('eliminarPrePosts') }}">
      {{ csrf_field() }}
      @if ($finalizado)
        <button type="submit" id="eliminar-pre-postulantes" class="btn btn-success" disabled>Publicar Ganadores</button>
      @else 
        <button type="submit" id="eliminar-pre-postulantes" class="btn btn-success">Publicar Ganadores</button>
      @endif
    </form>
  </div>
</div>
@endsection