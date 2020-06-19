<div class="table-requests">
    <table class="table table-bordered">
          <thead class="thead-dark">
              <tr>
                  <th class="font-weight-normal" scope="col">Descripcion de Meritos</th>
                  <th class="font-weight-normal" scope="col">Porcentaje</th>
                  <th class="font-weight-normal" scope="col">Nota</th>
                  <th class="font-weight-normal" scope="col">Editar</th>
              </tr>
          </thead>
          <tbody class="bg-white">

              @foreach($lista as $item)
                  <tr>
                      <td class="{{ $item[0] === null? 'font-weight-bold': 'text-lowercase' }}"
                          style="padding-left: {{ espacios($item[1]) }}px;">{{ $item[1] }}</td>
                      <td class="text-center">{{ $item[2] }}</td>
                      <td class="text-center">{{ $item[4] }}</td>
                      <td>
                        @if($item[5])
                            opcion
                        @endif
                      </td>
                  </tr>
              @endforeach

          </tbody>
    </table>
</div>