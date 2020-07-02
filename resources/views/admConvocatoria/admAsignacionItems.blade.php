@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <h3>Asignacion de items</h3>
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
              <div class="table-requests1">
                <table id= "notas{{ $auxiliatura->id}}" class="table table-striped table-bordered">
                  <thead class="thead-dark text-left">
                    <tr>
                      <th class="font-weight-normal" scope="col">Item</th>
                      <th class="font-weight-normal" scope="col">CI</th>
                      <th class="font-weight-normal" scope="col">Apellidos</th>
                      <th class="font-weight-normal" scope="col">Nombres</th>
                      <th class="font-weight-normal" scope="col">Nota final</th>
                      <th class="font-weight-normal" scope="col">Cantidad Items</th>
                      <th class="font-weight-normal" scope="col">Asignar</th>
                    </tr>
                  </thead>
                  <tbody>
                      @php $num=1; @endphp
                    @if($listaPost->has($auxiliatura->id))
                      @foreach ($listaPost[$auxiliatura->id] as $item)
                        <tr>
                          <td>{{ $num++ }}</td>
                          <td>{{ $item->ci }}</td>
                          <td>{{ $item->apellido }}</td>
                          <td>{{ $item->nombre }}</td>
                          <td>-</td>
                          <td>1</td>
                          <td>
                            <form class="d-inline" action="#" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-link">
                                  <img src="{{ asset('img/add512.png') }}" width="30" height="32">
                                </button>
                              </form>
                              <form class="d-inline" action="#" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-link">
                                  <img src="{{ asset('img/minus512.png') }}" width="30" height="32">
                                </button>
                              </form>
                              <form class="d-inline" action="#" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">
                                  <img src="{{ asset('img/trash.png') }}" width="25" height="30">
                                </button>
                              </form>
                    </td>
                          </tr>
                      @endforeach
                    @endif
                  </tbody>   
                </table>
              </div>
          </div>
          {{ $initContent = false  }}
          @endforeach
      </div>
  </div>
</div>
    
@endsection