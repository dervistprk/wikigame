@extends('layouts.app')
@section('title', __('Oyunseverlerin Buluşma Noktası'))
@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-warning m-2 alert-dismissible fade show">
                {!! session()->get('message') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="latest-header">{{ __('Son Eklenen Oyunlar') }}</h2>
        @if($latest_games->count() > 0)
            @foreach($latest_games as $latest_game)
                <div class="card-deck d-inline-block m-2 game-card" title="{{ $latest_game->name }}">
                    <div class="card content-cards">
                        <a href="{{ route('game', [$latest_game->slug]) }}" class="stretched-link" data-toggle="tooltip"
                           data-bs-placement="top" title="{{ $latest_game->name }}"></a>
                        <img class="card-img-top img-fluid" src="{{ $latest_game->cover_image }}"
                             alt="{{ $latest_game->name }}">
                    </div>
                </div>
            @endforeach
            @if($latest_games->count() >= 8)
                <h4 class="text-center m-2">
                    <a href="{{ route('all-games') }}"
                       class="text-decoration-none dev-header hover-underline-animation">{{ __('Tümünü Gör') }}</a>
                </h4>
            @endif
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı oyun bulunamadı.') }}
            </div>
        @endif
        <hr>
        <h2 class="popular-header">{{ __('Popüler Oyunlar') }}</h2>
        @if($popular_games->count() > 0)
            @foreach($popular_games as $popular_game)
                <div class="card-deck d-inline-block m-2 game-card" title="{{ $popular_game->name }}">
                    <div class="card content-cards">
                        <a href="{{ route('game', [$popular_game->slug]) }}" class="stretched-link"
                           data-toggle="tooltip" data-bs-placement="top" title="{{ $popular_game->name }}"></a>
                        <img class="card-img-top img-fluid lazyload" data-src="{{$popular_game->cover_image}}"
                             src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $popular_game->name }}"
                             loading="lazy">
                    </div>
                </div>
            @endforeach
            @if($popular_games->count() >= 8)
                <h4 class="text-center m-2">
                    <a href="{{ route('all-games') }}"
                       class="text-decoration-none dev-header hover-underline-animation">{{ __('Tümünü Gör') }}</a>
                </h4>
            @endif
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı oyun bulunamadı.') }}
            </div>
        @endif
        <hr>
        <h2 class="popular-header">{{ __('Son Eklenen Makaleler') }}</h2>
        @if($latest_articles->count() > 0)
            @foreach($latest_articles as $latest_article)
                <div class="card-deck d-inline-block m-2 article-card" title="{{ $latest_article->title }}">
                    <div class="card content-cards">
                        <a href="{{ route('article', [$latest_article->slug]) }}" class="stretched-link"
                           data-toggle="tooltip" data-bs-placement="top" title="{{ $latest_article->title }}"></a>
                        <img class="card-img-top img-fluid lazyload" data-src="{{$latest_article->image}}"
                             src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $latest_article->title }}"
                             loading="lazy">
                        <div class="card-body">
                            <p class="card-text">{{ $latest_article->sub_title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($latest_articles->count() >= 4)
                <h4 class="text-center m-2">
                    <a href="{{ route('articles') }}"
                       class="text-decoration-none dev-header hover-underline-animation">{{ __('Tümünü Gör') }}</a>
                </h4>
            @endif
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı makale bulunamadı.') }}
            </div>
        @endif
        <hr>
        <h2 class="popular-header">{{ __('Popüler Makaleler') }}</h2>
        @if($popular_articles->count() > 0)
            @foreach($popular_articles as $popular_article)
                <div class="card-deck d-inline-block m-2 article-card" title="{{ $popular_article->title }}">
                    <div class="card content-cards" style="max-width: 500px; max-height: 400px;">
                        <a href="{{ route('article', [$popular_article->slug]) }}" class="stretched-link"
                           data-toggle="tooltip" data-bs-placement="top" title="{{ $popular_article->title }}"></a>
                        <img class="card-img-top img-fluid lazyload" data-src="{{$popular_article->image}}"
                             src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $popular_article->title }}"
                             loading="lazy">
                        <div class="card-body">
                            <p class="card-text">{{ $popular_article->sub_title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($popular_articles->count() >= 4)
                <h4 class="text-center m-2">
                    <a href="{{ route('articles') }}"
                       class="text-decoration-none dev-header hover-underline-animation">{{ __('Tümünü Gör') }}</a>
                </h4>
            @endif
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı makale bulunamadı.') }}
            </div>
        @endif
    </div>
@endsection