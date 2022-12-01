<!-- Carousel wrapper -->
<div id="carouselExampleIndicators" class="carousel slide w-75" data-bs-ride="carousel" data-bs-interval="6000">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
        @for($i = 1; $i <= $game->images->count() + $game->videos->count(); $i++)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}"
                    aria-label="Slide {{ $i + 1 }}"></button>
        @endfor
    </div>
    <!-- Inner -->
    <div class="carousel-inner">
        @foreach($game->videos as $video)
            <div id="game-video" class="carousel-item @if($loop->first) active @endif resp-container">
                <iframe id="game-video-{{ $video_count }}" class="resp-iframe d-block w-100 img-fluid"
                        src="{{ $video->url }}?enablejsapi=1" allow="encrypted-media" allowfullscreen></iframe>
            </div>
            @php $video_count++; @endphp
        @endforeach
        <div class="carousel-item">
            <img src="{{ $game->image1 }}" class="d-block w-100 img-fluid" alt="{{ $game->name }}">
        </div>
        @foreach($game->images as $image)
            <div class="carousel-item">
                <img src="{{ $image->path }}" class="d-block w-100 img-fluid" alt="{{ $game->name }}">
            </div>
        @endforeach
    </div>
    <!-- Controls -->
    <button class="carousel-control-prev" id="prev-button" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
        <i class="fas text-warning fa-arrow-alt-circle-left" id="prev-arrow-icon"></i>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" id="next-button" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
        <i class="fas text-warning fa-arrow-alt-circle-right" id="next-arrow-icon"></i>
        <span class="visually-hidden">Next</span>
    </button>
</div>