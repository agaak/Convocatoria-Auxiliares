@extends('layout')

@section('content')
<div class="container-carousel p-0">

    {{-- Carrusel --}}

    <div id="carouselHome" class="carousel slide mb-3" data-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item carousel-none text-right active">
                <img src="{{ asset('img/home-1.jpeg') }}" class="d-block w-100" alt="home1">
                <div class="carousel-links">
                    <a href="#" class="text-dark mb-1">CONCURSO PARA <span class="font-weight-bold">AUXILIATURA
                            DOCENCIA</span></a>
                    <br>
                    <a href="#" class="text-dark">Decubre oportunidades</a>
                </div>
            </div>
            <div class="carousel-item carousel-none text-right">
                <img src="{{ asset('img/home-2.jpeg') }}" class="d-block w-100" alt="home2">
                <div class="carousel-links carousel-links-2">
                    <a href="#" class="text-dark mb-1">CONCURSO PARA <span class="font-weight-bold">AUXILIATURA
                            LABORATORIO</span></a>
                    <br>
                    <a href="#" class="text-dark">Decubre oportunidades</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselHome" data-slide="prev">
            <span class="carousel-control-prev-icon icono-carousel"></span>
        </a>
        <a class="carousel-control-next" href="#carouselHome" data-slide="next">
            <span class="carousel-control-next-icon icono-carousel"></span>
        </a>
    </div>

    {{-- Anuncios --}}
    
    <h4 class="text-center" style="margin-top: 20px">Anuncios</h4>

    {{-- Carrusel de cards con datos grals. de un aviso --}}
    @component('components.carruselAviso', 
    ['listAvisos' => $listAvisos])
    @endcomponent
</div>
@endsection