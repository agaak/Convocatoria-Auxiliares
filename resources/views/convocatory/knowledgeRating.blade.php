@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h5 style="margin: 25px" class="font-weight-bold">Calificacion de Conocimientos</h5>

        <!-- Table -->
    <div class="table-requests">
        <table class="table table-bordered" style="text-align: center">
          <thead class="thead-dark">
            <tr>
              <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">#</th>
              <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Tematica</th>
              <th style="font-weight: normal" scope="col" colspan="6">Codigo de Auxiliatura</th>
            </tr>
            <tr>
              <th style="font-weight: normal" scope="col">LCO-ADM</th>
              <th style="font-weight: normal" scope="col">LDS-ADM</th>
              <th style="font-weight: normal" scope="col">LDS-AUX</th>
              <th style="font-weight: normal" scope="col">LM-AUX</th>
              <th style="font-weight: normal" scope="col">LM-ADM</th>
              <th style="font-weight: normal" scope="col">LM-AUX</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-light">1</td>
              <td class="table-light">ADM LINUX</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td><a class="options" data-toggle="modal" data-target="#exampleModalCenter">
                  <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                </a>
                <a class="options">
                  <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                </a></td>
            </tr>
          </tbody>
        </table>
        </div>

    
    <div class="my-5 py-5 text-center">
        <a href="{{ route('knowledgeRating') }}" class="btn btn-info" tabindex="-1" role="button" aria-disabled="true">Finalizar</a>
    </div>
    </div>
@endsection