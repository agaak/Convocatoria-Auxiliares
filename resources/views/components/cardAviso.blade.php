<div class="col-md-4 mb-3 mt-3">
    <div class="card text-center" style="height: 300px">
        <div class="card-header" style="font-size:14px; background: #0A091B; color: white; height: 65px;"><strong>{{ $aviso->titulo}}</strong><br>{{'(Departamento: '.$aviso->nombre.')' }}</div>
        <div class="card-body overflow-auto" data-spy="scroll" style="height: 100px" align="left">
            <p>
                <strong>{{ $aviso->titulo_aviso.': ' }}</strong>{{ $aviso->descripcion_aviso }}
            </p>
        </div>
        <div class="card-footer text-muted" style="font-size:15px"><strong>Subido: </strong>{{ $aviso->updated_at }}</div>
        <div class="btn-home">
            <a href="{{ route('helper.redirect.ver', $aviso->id_convocatoria) }}" class="btn btn-success btn-sm text-white">Ir a convocatoria</a>
        </div>
    </div>
    {{ $slot }}
</div>