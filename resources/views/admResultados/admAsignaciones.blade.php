@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

<div class="overflow-auto content">
  <h3>Asignacion de Auxiliaturas</h3>
  <div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      @php $initTabs = session()->get('id_tab') == null ?$listaAux[0]->id:session()->get('id_tab') @endphp
      @foreach ($listaAux as $auxiliatura)
          <li class="nav-item">
            <a class="nav-link{{ $initTabs==$auxiliatura->id ? " active" : '' }}" id={{ $auxiliatura->id }} data-toggle="tab" 
              href="#{{ "body".$auxiliatura->id }}" role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
              {{ $auxiliatura->nombre_aux }}
            </a>
          </li>
          @endforeach
    </ul>
    @php $initContent = session()->get('id_tab') == null ?$listaAux[0]->id:session()->get('id_tab'); @endphp
    <div class="tab-content" id="myTabContent">
      @foreach ($listaAux as $auxiliatura)
        <div class="tab-pane fade{{ $initContent==$auxiliatura->id ? " show active" : '' }}" id={{ "body".$auxiliatura->id}} 
          role="tabpanel" aria-labelledby={{ $auxiliatura->id}}>
          <h6 class="my-3">Total de auxiliaturas requeridas: {{ $auxiliatura->cant_aux}}</h6>
            <div class="table-requests1">
              <table id= "notas{{ $auxiliatura->id}}" class="table table-striped table-bordered" style="width: 100%">
                <thead class="thead-dark text-center">
                  <tr>
                    <th class="font-weight-normal" scope="col">Estado</th>
                    <th class="font-weight-normal" scope="col">CI</th>
                    <th class="font-weight-normal" scope="col">Apellidos</th>
                    <th class="font-weight-normal" scope="col">Nombres</th>
                    <th class="font-weight-normal" scope="col">Nota final</th>
                    <th class="font-weight-normal" scope="col">Horas Acumuladas</th>
                    <th class="font-weight-normal" scope="col">Cantidad Auxiliaturas</th>
                    @if (!$finalizado) <th class="font-weight-normal" scope="col">Acciones</th> @endif
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
                        <td class="text-center" style="vertical-align: middle;">{{ $item->estado }}</td>
                        <td class="text-center" style="vertical-align: middle;">{{ $item->ci }}</td>
                        <td style="vertical-align: middle;">{{ $item->apellido }}</td>
                        <td style="vertical-align: middle;">{{ $item->nombre }}</td>
                        <th style="vertical-align: middle;" class="text-center">{{ $item->calificacion }}</th>
                        <td style="vertical-align: middle;" class="text-center">40 hrs</td>
                        <th style="vertical-align: middle;" class="text-center">
                          @if($item->item===null)
                              {{ "0" }}
                          @else
                              {{ $item->item }}
                          @endif
                        </th>
                        @if (!$finalizado)
                        <td class="text-center">
                          @if($item->item===null || $item->item == 0)
                            <form class="d-inline" action="{{ route('asignar') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" value="{{ $item->id }}" readonly>
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura }}" readonly>
                              <input class="btn btn-light btn-block" type="submit" style="background-color:#CCEAEC; color:rgb(0, 0, 0);" value="Asignar">
                            </form>
                          @else
                          <form class="d-inline" action="{{ route('asignar') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" value="{{ $item->id }}" readonly>
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura }}" readonly>
                              <input class="btn btn-light" type="submit" style="background-color:#AEF1B5; color:rgb(0, 0, 0);" value="Asignar mas">
                            </form>
                            <form class="d-inline" action="{{ route('quitar') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" value="{{ $item->id }}" readonly> 
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura }}" readonly>
                              <input class="btn btn-light" type="submit" onclick="mensaje()" style="background-color:#F1AEAE; color:rgb(0, 0, 0);" value="Quitar">
                            </form>
                            @endif
                        </td>
                        @endif
                      </tr>
                    @endforeach
                  @endif
                </tbody>   
              </table>
              {{-- @if (!$finalizado)
                <div class="container text-right">
                  <button type="button" class="btn btn-dark my-3 col-xs-2" data-toggle="modal" 
                          data-target="#invitarPostulanteModal" data-asig_id_auxiliatura="{{ $auxiliatura->id}}">Invitar postulante</button>
                </div>
              @endif --}}
            </div>
        </div>
          
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
                      <button type="button" class="btn btn-primary" onclick="comprobarInvitado({{ $listaPost }})" >Comprobar Postulante</button>
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
      @if ($finalizado || count($listaPost) == 0)
        <button type="submit" id="eliminar-pre-postulantes" class="btn btn-success" disabled>Publicar Ganadores</button>
      @else 
        <button type="submit" id="eliminar-pre-postulantes" class="btn btn-success">Publicar Ganadores</button>
      @endif
    </form>
  </div>
</div>
<script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
@foreach ($listaAux as $auxiliatura)
<script>
    $(document).ready(function() {
        $('#notas{{ $auxiliatura->id}}').DataTable( {
            "pageLength":70,
            responsive: true,
            "columnDefs": [
            // { "orderable": true},
            { "visible": false, "targets": 0 }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },"bLengthChange": false,
            orderFixed: [[ 0, 'asc' ],[ 4, 'desc' ]],
            rowGroup: {
                dataSrc: 0,startRender: function (rows, group) {
                return group + ' (' + rows.count() + ' postulantes)';
        }
            },
            
        } );
    } );
</script>
@endforeach
@endsection