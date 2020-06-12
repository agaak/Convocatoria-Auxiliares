
<div class="table-requests">
    <table class="table table-bordered">
          <thead class="thead-dark">
              <tr>
                  <th class="font-weight-normal" scope="col">Descripcion de Meritos</th>
                  <th class="font-weight-normal" scope="col">Porcentaje</th>
                  <th class="font-weight-normal" scope="col">Opciones</th>
              </tr>
          </thead>
          <tbody class="bg-white">

              @foreach($listaOrdenada  as $item)
                  <tr>
                      <td class="{{ $item[0] === null? 'font-weight-bold': 'text-lowercase' }}"
                          style="padding-left: {{ espacios($item[1]) }}px;">{{ $item[1] }}</td>
                      <td class="text-center">{{ $item[2] }}</td>
                      <td class="text-center">
                          @if ($item[0] === null)
                          <a type="button" data-toggle="modal" data-target="#meritModalEdit" onclick="editMeritModal({{ convertir($item) }})">
                              <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                          </a>
                          @else
                          <a type="button" data-toggle="modal" data-target="#subMeritModalEdit"
                              onclick="editSubMeritModal({{ convertir($item) }})">
                              <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                          </a>
                          @endif
                          <form class="d-inline" action="{{ route('calificacion-meritos.destroy', $item[3]) }}" method="POST">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-link">
                                  <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                              </button>
                          </form>
                      </td>
                  </tr>
              @endforeach

          </tbody>
    </table>
</div>