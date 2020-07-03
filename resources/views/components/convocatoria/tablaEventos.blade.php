<div class="table-requests {{session()->get('ver')? 'my-5': ''}}">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <thead class="thead-dark text-center">
                <tr>
                    <th class="font-weight-normal" scope="col">Evento</th>
                    <th class="font-weight-normal" scope="col">Lugar</th>
                    <th class="font-weight-normal" scope="col">Fecha Inicial</th>
                    <th class="font-weight-normal" scope="col">Fecha Fin</th>
                    @if (!session()->get('ver'))
                    <th class="font-weight-normal" scope="col">Opciones</th>
                    @endif
                </tr>
            </thead>
        <tbody class="bg-white" style="vertical-align: middle">
            @foreach($importantDatesList as $item)
                <tr>
                    <td style="vertical-align: middle;">{{ $item->titulo_evento }}</td>
                    <td style="vertical-align: middle;">{{ $item->lugar_evento }}</td>
                    <td style="vertical-align: middle;" class="text-center">{{ $item->fecha_inicio }}</td>
                    <td style="vertical-align: middle;" class="text-center">{{ $item->fecha_final }}</td>
                    @if (!session()->get('ver'))
                        <td style="vertical-align: middle;" class="text-center">
                            <a type="button" onclick="editDatesList({{ convertir($item) }})" data-toggle="modal"
                                data-target="#importantDatesModalUpdate">
                                <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                            </a>
                            
                            <form class="d-inline" action="{{ route('importantDatesDelete', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">
                                    <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                                </button>
                            </form>

                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>