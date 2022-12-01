@extends('layouts.app')
@section('title', isset($article->title) ? $article->title : 'Kayıtlı Makale Bulunamadı')
@section('content')
    @if(isset($article))
        <div class="container">
            <h2 class="game-header">{{ $article->title }}</h2>
            <img src="{{ $article->image }}" alt="{{ $article->title }}" title="{{ $article->title }}"
                 class="img-fluid rounded w-100 h-100 d-block">
            <div class="game-info m-3 p-3 rounded">
                <h5 class="game-subtitle">{{$article->sub_title}}</h5>
                <p>{!! $article->writing !!}</p>
            </div>
            @if($random_articles->count() > 0)
                <h2 class="game-header text-center">{{ __('Bunları da Okumak İsteyebilirsiniz') }}</h2>
                @foreach($random_articles as $random_article)
                    <div class="card-deck d-inline-block m-2" title="{{ $random_article->title }}">
                        <div class="card content-cards article-card">
                            <img class="card-img-top img-fluid lazyload" data-src="{{$random_article->image}}"
                                 src="{{ asset('assets/preview-image-large.png') }}"
                                 alt="{{ $random_article->title }}" title="{{ $random_article->title }}" loading="lazy">
                            <div class="card-body">
                                <h5 class="card-title">{{ $random_article->title }}</h5>
                                <a href="{{ route('article', [$random_article->slug]) }}"
                                   class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    @endif
    @else
        <div class="container">
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı makale bulunamadı.') }}
            </div>
        </div>
    @endif
@endsection