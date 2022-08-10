@extends('layouts.app')
@section('title', 'Oyunseverlerin Buluşma Noktası')
@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-warning m-2 alert-dismissible fade show">
                {!! session()->get('message') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <h2 class="latest-header">Son Eklenen Oyunlar</h2>
        @if(isset($latest_games))
            @foreach($latest_games as $latest_game)
                <div class="card-deck d-inline-block m-1" title="{{ $latest_game->name }}">
                    <div class="card">
                        <a href="{{ route('game', [$latest_game->slug]) }}" class="stretched-link" data-toggle="tooltip" data-placement="top" title="{{ $latest_game->name }}"></a>
                        <img class="card-img-top img-fluid" src="{{$latest_game->cover_image}}" alt="{{ $latest_game->name }}">
                    </div>
                </div>
            @endforeach
            @if($latest_games->count() >= 8)
                <h4 class="text-center m-2">
                    <a href="{{ route('all-games') }}" class="text-decoration-none dev-header hover-underline-animation">Tümünü Gör</a>
                </h4>
            @endif
        @else
            <div class="alert alert-danger m-2">
                Sistemde kayıtlı oyun bulunamadı.
            </div>
        @endif
        <hr>
        <h2 class="popular-header">Popüler Oyunlar</h2>
        @if(isset($popular_games))
            @foreach($popular_games as $popular_game)
                <div class="card-deck d-inline-block m-1" title="{{ $popular_game->name }}">
                    <div class="card">
                        <a href="{{ route('game', [$popular_game->slug]) }}" class="stretched-link" data-toggle="tooltip" data-placement="top" title="{{ $popular_game->name }}"></a>
                        <img class="card-img-top img-fluid lazyload" data-src="{{$popular_game->cover_image}}" src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $popular_game->name }}" loading="lazy">
                    </div>
                </div>
            @endforeach
            @if($popular_games->count() >= 8)
                <h4 class="text-center m-2">
                    <a href="{{ route('all-games') }}" class="text-decoration-none dev-header hover-underline-animation">Tümünü Gör</a>
                </h4>
            @endif
        @else
            <div class="alert alert-danger m-2">
                Sistemde kayıtlı oyun bulunamadı.
            </div>
        @endif
        <hr>
        <h2 class="popular-header">Son Eklenen Makaleler</h2>
        @if(isset($latest_articles))
            @foreach($latest_articles as $latest_article)
                <div class="card-deck d-inline-block m-1" title="{{ $latest_article->title }}">
                    <div class="card" style="max-width: 500px; max-height: 400px;">
                        <a href="{{ route('game', [$latest_article->slug]) }}" class="stretched-link" data-toggle="tooltip" data-placement="top" title="{{ $latest_article->title }}"></a>
                        <img class="card-img-top img-fluid lazyload" data-src="{{$latest_article->image}}" src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $latest_article->title }}" style="width: 500px; height: 300px" loading="lazy">
                        <div class="card-body">
                            <p class="card-text" style="font-size: 14px; font-family: 'Helvetica Neue', sans-serif">{{ $latest_article->sub_title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($latest_articles->count() >= 4)
                <h4 class="text-center m-2">
                    <a href="{{ route('articles') }}" class="text-decoration-none dev-header hover-underline-animation">Tümünü Gör</a>
                </h4>
            @endif
        @else
            <div class="alert alert-danger m-2">
                Sistemde kayıtlı makale bulunamadı.
            </div>
        @endif
        <hr>
        <h2 class="popular-header">Popüler Makaleler</h2>
        @if(isset($popular_articles))
            @foreach($popular_articles as $popular_article)
                <div class="card-deck d-inline-block m-1" title="{{ $popular_article->title }}">
                    <div class="card" style="max-width: 500px; max-height: 400px;">
                        <a href="{{ route('game', [$popular_article->slug]) }}" class="stretched-link" data-toggle="tooltip" data-placement="top" title="{{ $popular_article->title }}"></a>
                        <img class="card-img-top img-fluid lazyload" data-src="{{$popular_article->image}}" src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $popular_article->title }}" style="width: 500px; height: 300px" loading="lazy">
                        <div class="card-body">
                            <p class="card-text" style="font-size: 14px; font-family: 'Helvetica Neue', sans-serif">{{ $popular_article->sub_title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($popular_articles->count() >= 4)
                <h4 class="text-center m-2">
                    <a href="{{ route('articles') }}" class="text-decoration-none dev-header hover-underline-animation">Tümünü Gör</a>
                </h4>
            @endif
        @else
            <div class="alert alert-danger m-2">
                Sistemde kayıtlı makale bulunamadı.
            </div>
        @endif
    </div>
@endsection