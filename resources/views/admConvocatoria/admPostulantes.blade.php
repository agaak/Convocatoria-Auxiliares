@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <h3 class="text-uppercase text-center">Postulantes</h3>
    <!-- Trigger modal -->
     <button type="button" class="btn btn-dark my-3" data-toggle="modal" 
     data-target="#modal" >Registrar nuevo postulante</button>

    <!-- Table -->
    <div class="table-requests1">
        <table class="table table-bordered" style="text-align:center">
        <thead class="thead-dark">
            <tr> 
            <th style="font-weight: normal" scope="col">CI</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
            @foreach($listPostulantes as $item)
                <tr>
                <th style="font-weight: normal">{{ $item->ci }}</th>
                <th style="font-weight: normal">{{ $item->nombre }}</th>
                <th style="font-weight: normal">{{ $item->apellido }}</th>
                <th style="font-weight: normal">{{ $item->habilitado }}</th>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <br>
    
</div>
    
@endsection