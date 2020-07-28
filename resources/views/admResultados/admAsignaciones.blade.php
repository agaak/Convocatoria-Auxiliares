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
          <h6 class="my-3">Items requeridos: {{ $auxiliatura->items_libres}} - carga horaria mes: {{ $auxiliatura->horas_mes}}</h6>
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
                    alert('Esta seguro de quitar el item'); 
                  }
                </script>
                <div class="text-center">
                {!! $errors->first('horas', '<strong class="message-error text-danger">:message</strong>') !!}
                </div>
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
                        <td style="vertical-align: middle;" class="text-center">{{ $item->horas }} hrs</td>
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
                              <input type="hidden" name="id" value="{{ $item->id }}">
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura}}">
                              <input type="hidden" name="horas" value="{{ $item->horas+$auxiliatura->horas_mes }}">
                              <input class="btn btn-light btn-block" onclick="datosAsignacion({{ $listaPost[$auxiliatura->id] }}, {{ $item }})" type="submit" style="background-color:#CCEAEC; color:rgb(0, 0, 0);" value="{{strcmp($item->estado,'Postulante Reprobado')==0?'Asignar por Invitacion':'Asignar'}}">
                            </form>
                          @else
                          <form class="d-inline" action="{{ route('asignar') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="id" value="{{ $item->id }}">
                              <input type="hidden" name="ida" value="{{ $item->id_auxiliatura }}">
                              <input type="hidden" name="horas" value="{{ $item->horas+$auxiliatura->horas_mes }}">

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