<div class="table-requests {{session()->get('ver')? 'my-4': ''}}">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="font-weight-normal" scope="col">Descripcion de Meritos</th>
                <th class="font-weight-normal text-center" scope="col">Porcentaje</th>
                @if (!session()->get('ver'))
                    <th class="font-weight-normal text-center" scope="col">Opciones</th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white">

            @foreach($listaOrdenada as $item)
                <tr>
                    <td class="{{ $item[0] === null? 'font-weight-bold': 'text-lowercase' }}"
                        style="padding-left: {{ espacios($item[1]) }}px;">{{ $item[1] }}</td>
                    <td class="text-center">{{ $item[2] }}</td>
                    @if (!session()->get('ver'))
                        <td class="text-center">
                            @if ($item[0] === null)
                                <a type="button" data-toggle="modal" data-target="#meritModalEdit"
                                    onclick="editMeritModal({{ convertir($item) }})">
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
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
</div>