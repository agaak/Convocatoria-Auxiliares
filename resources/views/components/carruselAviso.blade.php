<div class="container text-center my-3">
    <div class="row mx-auto my-auto">
        @if($listAvisos->isNotEmpty())
            @if(count($listAvisos)>3)
                <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @php $num = 0; @endphp
            @endif
                        @foreach($listAvisos as $aviso)
                            @if(count($listAvisos)>3)
                                @if($num++ == 0)
                                    <div class="carousel-item active">
                                    @else
                                    <div class="carousel-item">
                                @endif
                            @endif
                                    
                            {{-- Visualizar card de aviso --}}
                            @component('components.cardAviso', 
                            ['aviso' => $aviso])
                            @endcomponent
                                    
                            @if(count($listAvisos)>3) </div> @endif
                        @endforeach
                    @if(count($listAvisos)>3)
                    </div>
                    <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"
                        style="height: 40px; width: 40px;"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"
                            style="height: 40px; width: 40px;"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    </div> @endif
        @else
        <div style="height: 100px;width:100%;display: flex;justify-content: center;align-items: center;">
            <h2 style="color: #9c9c9c">No hay Avisos</h2>
        </div>
        @endif
    </div>
    {{ $slot }}
</div>