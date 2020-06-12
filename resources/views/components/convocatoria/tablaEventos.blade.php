<div class="table-requests">
  <table class="table table-bordered">
      <thead class="thead-dark">
          <thead class="thead-dark text-center">
              <tr>
                  <th class="font-weight-normal" scope="col">Evento</th>
                  <th class="font-weight-normal" scope="col">Lugar</th>
                  <th class="font-weight-normal" scope="col">Fecha Inicial</th>
                  <th class="font-weight-normal" scope="col">Fecha Fin</th>
                  <th class="font-weight-normal" scope="col">Opciones</th>
              </tr>
          </thead>
      <tbody class="bg-white" style="vertical-align: middle">
          @foreach($importantDatesList as $item)
              <tr>
                  <td style="vertical-align: middle;">{{ $item->titulo_evento }}</td>
                  <td style="vertical-align: middle;">{{ $item->lugar_evento }}</td>
                  <td style="vertical-align: middle;" class="text-center">{{ $item->fecha_inicio }}</td>
                  <td style="vertical-align: middle;" class="text-center">{{ $item->fecha_final }}</td>
                  <td style="vertical-align: middle;" class="text-center">
                      <a type="button" onclick="editDatesList({{ convertir($item) }})" data-toggle="modal"
                          data-target="#importantDatesModalUpdate">
                          <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                      </a>
                      <form class="d-inline"
                          action="{{ route('importantDatesDelete', $item->id) }}"
                          method="POST" id="important-dates-delete">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <a type="submit" class="btn btn-link">
                              <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                          </a>
                      </form>

                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
</div>