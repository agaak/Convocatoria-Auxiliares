<div class="container text-center my-3">
        <div class="row mx-auto my-auto">
            @if(count($convos)>3)
                <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @php $num = 0; @endphp
            @endif
                        @foreach($convos as $convo)
                            @if(count($convos)>3)
                                @if($num++ == 0)
                                    <div class="carousel-item active">
                                    @else
                                    <div class="carousel-item">
                                @endif
                            @endif
                            
                            {{-- Visualizar Card de Datos Generales Convocatoria --}}
                            @component('components.cardConvocatoria', 
                                ['convo' => $convo, 'auxs' => $auxs])
                            @endcomponent
                            @if(count($convos)>3) </div> @endif
                        @endforeach
                    @if(count($convos)>3)
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
        </div>
    </div>