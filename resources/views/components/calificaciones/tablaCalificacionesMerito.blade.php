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
                      <td class="text-center">{{ $item->descripcion_merito }}</td>
                      <td class="text-center">{{ $item->porcentaje }}</td>
                      <td class="text-center">
                        @if(($item->calificacion)==null) -
                        @else {{$item->calificacion}}
                        @endif
                      </td>
                      <td class="text-center">
                            <a type="button" data-toggle="modal" data-target="#modalCalificar" onclick="">
                                <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                            </a>
                      </td>
                  </tr>
              @endforeach

          </tbody>
    </table>
</div>