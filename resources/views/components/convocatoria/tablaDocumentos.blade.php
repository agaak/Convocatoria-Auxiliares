<div class="table-requests {{session()->get('ver')? 'my-5': ''}}">
  <table class="table table-bordered table-striped mx-auto">
    <thead class="thead-dark">
      <tr>
        <th style="font-weight: normal" scope="col">#</th>
        <th style="font-weight: normal" scope="col">Descripcion</th>
        @if (!session()->get('ver'))
          <th style="font-weight: normal; width: 125px;" scope="col ">Opciones</th>
        @endif
      </tr>
    </thead>
    <tbody style="background-color: white">
      @foreach($documentos as $documento)
        <tr>
          <th scope="row">{{ chr($alphas++).')' }}</th>
          <td style="text-align: justify;">
            {{ $documento->descripcion }}
          </td>
          @if (!session()->get('ver'))  
            <td style="text-align: center">
              <a class="options" data-toggle="modal" data-target="#requirementsEditModal" data-dismiss="modal"
              onclick="requirementsEditModal({{ json_encode($documento) }}, {{  json_encode(chr($alphas-1)) }} )">
                <img src="{{ asset('img/pen.png') }}" width="25" height="25">
              </a>
                    
              <form class="d-inline" action="{{ route('documentoDelete', $documento->id) }}" method="POST">
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
  {{ $slot }}
</div>
