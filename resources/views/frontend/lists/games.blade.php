@foreach($games as $game)
    <div class="card-deck d-inline-block m-1" title="{{ $game->name }}">
        <div class="card content-cards">
            <img class="card-img-top img-fluid lazyload" data-src="{{$game->cover_image}}"
                 src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $game->name }}" title="{{ $game->name }}"
                 loading="lazy">
            <div class="card-body">
                <h6 class="card-title">{{ $game->name }}</h6>
                <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
@endforeach
<div class="m-1">{!! $games->links() !!}</div>

