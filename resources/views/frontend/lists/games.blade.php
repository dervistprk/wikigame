@foreach($games as $game)
    <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $game->name }}">
        <div class="card">
            <img class="card-img-top lazyload" data-src="{{$game->cover_image}}" src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $game->name }}" title="{{ $game->name }}" width="220" height="300" loading="lazy">
            <div class="card-body">
                <h6 class="card-title">{{ $game->name }}</h6>
                <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
@endforeach
<div style="margin: 15px 0 0 17px;">{{ $games->links() }}</div>

