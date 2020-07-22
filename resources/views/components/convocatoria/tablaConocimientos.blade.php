<div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      @php $initTabs = session()->get('id_conoc')==null? $list_aux[0]['id']: session()->get('id_conoc');@endphp
      @foreach ($list_aux as $auxiliatura)
        <li class="nav-item">
          <a class="nav-link{{ $initTabs==$auxiliatura->id ? " active" : '' }}" id={{ $auxiliatura->id }} data-toggle="tab" 
              href="#{{ "body".$auxiliatura->id }}" role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
            {{ $auxiliatura->nombre_aux }}
          </a>
        </li>
      @endforeach
  </ul>
  @php $initContent = session()->get('id_conoc')==null? $list_aux[0]['id']: session()->get('id_conoc'); @endphp
  <div class="tab-content" id="myTabContent">
      @foreach ($list_aux as $auxiliatura)
        <div class="tab-pane fade{{ $initContent==$auxiliatura->id ? " show active" : '' }}" id={{ "body".$auxiliatura->id}} 
          role="tabpanel" aria-labelledby={{ $auxiliatura->id}}>

          <!-- Button trigger modal -->
          @if (!session()->get('ver'))
          <div class="row my-3" style="margin-left: 3ch">
            <a class="text-decoration-none" type="button" 
            onclick="addModalTem({{json_encode($tematics[$auxiliatura->id][0]['tematics'])}})" 
              data-toggle="modal" data-id_auxiliatura="{{ $auxiliatura->id }}" data-target="#tematicaModal">
              <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
              <span class="mx-1">Añadir Tematica</span>
            </a>
          </div>  
          @endif

        <div class="table-requests {{session()->get('ver')? 'my-5': ''}}">
          <table class="table table-striped table-bordered" style="text-align: center">
            <thead class="thead-dark">
              <tr>
                <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">#</th>
                <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Tematica</th>
                <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Area de Evaluacion</th>
                <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Porcentaje</th>
                @if (!session()->get('ver'))
                  <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Opciones</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php $num = 1  @endphp
              @if($tems->has($auxiliatura->id))
              @foreach($tems[$auxiliatura->id] as $tematic)
                <tr>
                  <td class="table-light" scope="col" style="vertical-align: middle;" rowspan="{{count($tematic->areas)}}">{{ $num++ }}</td>
                  <td class="table-light" scope="col" style="vertical-align: middle;" rowspan="{{count($tematic->areas)}}">{{ $tematic->nombre }}</td>
                  @foreach($tematic->areas as $item)
                    <td class="table-light text-center">{{ $item->area }}</td>
                      @if($item->porcentaje == 0)
                          <td class="table-light">-</td>
                      @else
                          <td class="table-light">{{ $item->porcentaje }}</td>
                      @endif
                  @php break; @endphp
                  @endforeach
                  @if (!session()->get('ver'))
                    <td class="table-light" style="vertical-align: middle;" scope="col" rowspan="{{count($tematic->areas)}}">
                      <a class="options" data-toggle="modal" data-target="#tematicaEditModal" data-id="{{ $tematic->id }}"
                      data-nombre="{{ $tematic->nombre }}" data-id_auxiliatura="{{ $auxiliatura->id }}" 
                      data-dismiss="modal" onclick="selectTematicaModal({{json_encode($tems[$auxiliatura->id][$num-2])}},{{json_encode($areas)}})">
                        <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                      </a>

                      <form class="d-inline" action="{{ route('knowledgeRatingTematicDelete',['id_tem' => $tematic->id, 'id_aux' => $auxiliatura->id ]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-link">
                          <img src="{{ asset('img/trash.png') }}" width="25" height="25">
                        </button>
                      </form>
                    </td>
                  @endif
                </tr>
                <tr>
                  @php $first= true; @endphp
                  @foreach($tematic->areas as $item)
                    @if ($first)
                      @php $first= false; @endphp
                    @else
                        <td class="table-light text-center">{{ $item->area }}</td>
                        @if($item->porcentaje == 0)
                            <td class="table-light">-</td>
                        @else
                            <td class="table-light">{{ $item->porcentaje }}</td>
                        @endif
                    @endif
                  @endforeach
                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    @endforeach
</div>
</div>
<script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
@foreach ($list_aux as $auxiliatura)
<script>
  $(document).ready(function() {
      $('#notas{{ $auxiliatura->id}}').DataTable({
      
        "pageLength":50,
      "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
      },"bLengthChange": false,responsive: true,
      order: [[2, 'asc']],"bPaginate": false
      });
    
  });
</script>
@endforeach 