<div class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      @php $initTabs = true @endphp
      @foreach ($list_aux as $auxiliatura)
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
      @foreach ($list_aux as $auxiliatura)
        <div class="tab-pane fade{{ $initContent ? " show active" : '' }}" id={{ "body".$auxiliatura->id}} 
          role="tabpanel" aria-labelledby={{ $auxiliatura->id}}>

          <!-- Button trigger modal -->
          @if (!session()->get('ver'))
          <div class="row my-3" style="margin-left: 3ch">
            <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#tematicaModal">
              <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
              <span class="mx-1">Añadir Tematica</span>
            </a>
            {{-- <a class="text-decoration-none" style="margin-left: 15px" type="button" data-toggle="modal"
              data-target="#auxiliaturaModal"
              @if($requests->isNotEmpty()) onclick="selectAuxiliaturaModal({{ json_encode($porcentajes) }}, {{ json_encode($tems) }})" @endif>
              <img src="{{ asset('img/pen.png') }}" width="30" height="30">
              <span class="mx-1">Editar Auxiliatura</span>
            </a> --}}
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
              @foreach($tems[$auxiliatura->id] as $tematic)
                <tr>
                  <td class="table-light">{{ $num++ }}</td>
                  <td class="table-light">{{ $tematic->nombre }}</td>
                  @foreach($tematic->areas as $item)
                    <td class="table-light text-center">{{ $item->area }}</td>
                      @if($item->porcentaje == 0)
                          <td class="table-light">-</td>
                      @else
                          <td class="table-light">{{ $item->porcentaje }}</td>
                      @endif
                  @endforeach
                  @if (!session()->get('ver'))
                    <td class="table-light">
                      <a class="options" data-toggle="modal" data-target="#tematicaEditModal" data-id="{{ $tematic->id }}"
                      data-nombre="{{ $tematic->nombre }}" data-dismiss="modal">
                        <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                      </a>

                      <form class="d-inline" action="{{ route('knowledgeRatingTematicDelete', $tematic->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-link">
                          <img src="{{ asset('img/trash.png') }}" width="25" height="25">
                        </button>
                      </form>
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @php $initContent = false @endphp
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