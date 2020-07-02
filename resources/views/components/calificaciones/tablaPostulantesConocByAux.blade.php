<div class="table-requests">
    <table class="table table-bordered table-striped table-striped">
          <thead class="thead-dark text-center">
              <tr>
                  <th class="font-weight-normal" scope="col">N°</th>
                  <th class="font-weight-normal" scope="col">Carnet</th>
                  <th class="font-weight-normal" scope="col">Apellidos</th>
                  <th class="font-weight-normal" scope="col">Nombres</th> 
                  <th class="font-weight-normal" style="width: 90px" scope="col">Nota</th>
              </tr>
          </thead>
          <tbody class="bg-white">
                @php $cont = 1; @endphp
                <form method="POST" action="{{ route('calificarConoc.store') }}" id="request-notas">
                    <input type="hidden" name="id-tipo" value="2">
                @foreach ($postulantes as $item)
                    <tr>
                        <td class="text-center">{{ $cont++ }}</td>
                        <td class="text-center">{{ $item->ci }}</td>
                        <td class="text-center">{{ $item->apellido }}</td>
                        <td class="text-center">{{ $item->nombre }}</td>
                        
                        @if (auth()->check())
                            @if (auth()->user()->hasRoles(['evaluador']))
                            <td class="text-center">
                                    {{ csrf_field() }}
                                <input type="hidden" name="id-post[]" value="{{ $item->id_nota}}">
                                <input name="nota[]" type="number" class="form-control form-control-sm"
                                    placeholder="-" min="0" max="100" step="0.01" value="{{$item->calificacion}}" required style="text-align: center;"></td>
                            @else 
                                @if ($item->calificacion != null)
                                    <td class="text-center">{{ $item->calificacion }}</td>    
                                @else
                                    <td class="text-center">-</td>
                                @endif
                            @endif
                        @else
                            @if ($item->calificacion != null)
                                <td class="text-center">{{ $item->calificacion }}</td>    
                            @else
                                <td class="text-center">-</td>
                            @endif
                        @endif
                        
                    </tr>
                @endforeach
            </form>
          </tbody>
    </table>
    @if (auth()->check())
        @if (auth()->user()->hasRoles(['evaluador']))
            <div class="my-4 py-4 text-right">
                    <input class="btn btn-info" type="submit"  form="request-notas" value="Guardar">
            </div>
        @endif
    @endif
</div>