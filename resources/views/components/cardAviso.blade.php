<div class="list-cards">
    <div class="card">
        <div class="card-header" style="font-size:14px"><strong>{{ $aviso->titulo}}</strong><br>{{'(Departamento: '.$aviso->nombre.')' }}</div>
        <div class="card-body overflow-auto" data-spy="scroll" style="height: 100px"">
            <p>
                <strong>{{ $aviso->titulo_aviso.': ' }}</strong>{{ $aviso->descripcion_aviso }}
            </p>
        </div>
        <div class="card-footer text-muted p-1" style="font-size:15px"><strong>Subido: </strong>{{ $aviso->updated_at }}</div>
        <div class="btn-home">
            <a href="{{ route('helper.redirect.ver', $aviso->id_convocatoria) }}" class="btn btn-success btn-sm text-white">Ir a convocatoria</a>
        </div>
    </div>
</div>