<div class="table-requests">
    <table class="table table-striped table-bordered">
          <thead class="thead-dark text-center">
              <tr>
                  <th class="font-weight-normal" scope="col">N°</th>
                  <th class="font-weight-normal" scope="col">Nombres Completos</th>
                  <th class="font-weight-normal" scope="col">Carnet</th>
                  <th class="font-weight-normal" style="width: 90px" scope="col">Nota</th>
              </tr>
          </thead>
          <tbody class="bg-white">
                @php $cont = 1; @endphp
                <form method="POST" action="{{ route('calificarConoc.store') }}" id="request-notas">
                <input type="hidden" name="id-tipo" value="1">
                @foreach ($postulantes as $item)
                    <tr>
                        <td class="text-center">{{ $cont++ }}</td>
                        <td class="text-center">{{ $item[0]->apellido.' '.$item[0]->nombre }}</td>
                        <td class="text-center">{{ $item[0]->ci }}</td>
                        
                        @if (auth()->check())
                            @if (auth()->user()->hasRoles(['evaluador']))
                            <td class="text-center">
                                    {{ csrf_field() }}
                                    @foreach ($item as $postu)
                                        <input type="hidden" name="id_nota[]" value="{{ $postu->id_nota.','.$postu->id }}">   
                                    @endforeach
                                    <input type="hidden" name="id-post[]" value="{{ $item[0]->id }}">
                                    <input name="nota[]" type="number" class="form-control form-control-sm"
                                        placeholder="-" min="0" max="100" step="0.01" value="{{$item[0]->calificacion}}" required style="text-align: center;"></td>
                            @else 
                                @if ($item[0]->calificacion != null)
                                    <td class="text-center">{{ $item[0]->calificacion }}</td>    
                                @else
                                    <td class="text-center">-</td>
                                @endif
                            @endif
                        @else
                            @if ($item[0]->calificacion != null)
                                <td class="text-center">{{ $item[0]->calificacion }}</td>    
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