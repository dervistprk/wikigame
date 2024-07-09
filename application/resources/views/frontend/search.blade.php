@extends('layouts.app')
@section('title', __('Arama Sonuçları'))
@section('content')
    <div class="container">
        @if($games->count() == 0 && $developers->count() == 0 && $publishers->count() == 0 && $articles->count() == 0)
            <h2 class="game-header text-center">{{ __('Sonuç Bulunamadı') }}</h2>
            <div class="alert alert-secondary text-center mt-4">
                {{ __('Aradığınız kriterlere uygun sonuç bulunamadı.') }}
            </div>
        @endif
        @if($games->count() > 0)
            <h2 class="game-header">{{ __('Oyunlar') }}</h2>
            @foreach($games as $game)
                <div class="card-deck d-inline-block m-2 game-card" title="{{ $game->name }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid lazyload" data-src="{{$game->cover_image}}"
                             src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $game->name }}"
                             title="{{ $game->name }}" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $game->name }}</h6>
                            <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if($developers->count() > 0)
            <h2 class="game-header">{{ __('Geliştiriciler') }}</h2>
            @foreach($developers as $developer)
                <div class="card-deck d-inline-block m-2 dev-pub-card" title="{{ $developer->name }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid lazyload" data-src="{{$developer->image}}"
                             src="{{ asset('assets/preview-image-big.png') }}" alt="{{ $developer->name }}"
                             title="{{ $developer->name }}" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $developer->name }}</h6>
                            <a href="{{ route('developer', [$developer->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if($publishers->count() > 0)
            <h2 class="game-header">{{ __('Dağıtıcılar') }}</h2>
            @foreach($publishers as $publisher)
                <div class="card-deck d-inline-block m-2 dev-pub-card" title="{{ $publisher->name }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid lazyload" data-src="{{$publisher->image}}"
                             src="{{ asset('assets/preview-image-big.png') }}" alt="{{ $publisher->name }}"
                             title="{{ $publisher->name }}" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $publisher->name }}</h6>
                            <a href="{{ route('publisher', [$publisher->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if($articles->count() > 0)
            <h2 class="game-header">{{ __('Makaleler') }}</h2>
            @foreach($articles as $article)
                <div class="card-deck d-inline-block m-2 article-card" title="{{ $article->title }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid lazyload" data-src="{{$article->image}}"
                             src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $article->title }}"
                             title="{{ $article->title }}" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $article->title }}</h6>
                            <p class="card-text">{{ $article->sub_title }}</p>
                            <a href="{{ route('article', [$article->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
