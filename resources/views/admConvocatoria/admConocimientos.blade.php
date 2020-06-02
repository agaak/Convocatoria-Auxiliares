@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <h3 class="text-uppercase text-center">Comision de evaluacion de conocimientos</h3>
    <!-- Trigger modal -->
    <button type="button" class="btn btn-dark" data-toggle="modal" 
    data-target="#exampleModal" >Registrar nuevo evaluador</button>

    <!-- Table -->
    <div class="table-requests1">
        <table class="table table-bordered" style="text-align:Left"  >
        <thead class="thead-dark">
            <tr>
            <th style="font-weight: normal" scope="col" >Cod.Aux</th> 
            <th style="font-weight: normal" scope="col">Tematica</th>
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
            <th style="font-weight: normal">Introd1</th> 
            <th style="font-weight: normal"> Examen escrito</th>
            <th style="font-weight: normal">9999999</th>
            <th style="font-weight: normal">Constantine Bennedict </th>
            <th style="font-weight: normal">Papadopolis Vasilievich</th>
            <th style="font-weight: normal">correocreadfullpro@hotmail.com</th>
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
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    </div>

</div>
    
@endsection