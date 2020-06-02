@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <h3 class="text-uppercase text-center">Comision de evaluacion de meritos</h3>

    <!-- Trigger modal -->
    <button type="button" class="btn btn-dark" data-toggle="modal" 
    data-target="#exampleModal" >Registrar nuevo evaluador</button>
 
    <!-- Table -->
    <div class="table-requests1">
        <table class="table table-bordered" style="text-align: Left"  >
        <thead class="thead-dark">
            <tr> 
            <th style="font-weight: normal" scope="col">CI</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Email</th>
            <th style="font-weight: normal" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
            <div style="visibility: hidden"> {{ $num = 1 }}</div>
            <tr>
            <th style="font-weight: normal">123456789 </th>
            <th style="font-weight: normal">Valquiria Frederica </th>
            <th style="font-weight: normal">Morales De la Fuente</th>
            <th style="font-weight: normal">correooficialValquiria@hotmail.com</th>
            <th>
                <button type="submit" class="btn btn-link">
                <img src="{{ asset('img/pen.png') }}" width="26" height="26">
                </button> 
                <button type="submit" class="btn btn-link">
                <img src="{{ asset('img/trash.png') }}" width="26" height="26">
                </button>    
            </th>
            </tr>
        </tbody>
        </table>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="requestEditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    </div>
</div>
    
@endsection