@extends('layouts.app')
@section('title', isset($article->title) ? $article->title : 'Kayıtlı Oyun Bulunamadı')
@section('content')
    @if(isset($article))
        <div class="container">
            <h2 class="game-header">{{ $article->title }}</h2>
            <img src="{{ $article->image }}" alt="{{ $article->title }}" title="{{ $article->title }}" width="980" height="440" style="margin-left: 120px">
            <div class="game-info m-3 p-3 rounded">
                <h5 class="game-subtitle">{{$article->sub_title}}</h5>
                <p>{!! $article->writing !!}</p>
            </div>
            <h2 class="game-header">Bunları da Okumak İsteyebilirsiniz</h2>
            @foreach($random_articles as $random_article)
                <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $random_article->title }}">
                    <div class="card" style=" max-width: 360px; max-height: 320px">
                        <img class="card-img-top lazyload" data-src="{{$random_article->image}}" src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $random_article->title }}" title="{{ $random_article->title }}" width="360" height="220" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $random_article->title }}</h6>
                            <a href="{{ route('article', [$random_article->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
                <div class="alert alert-secondary text-center m-2">
                    Sistemde kayıtlı makale bulunamadı.
                </div>
            @endif
        </div>
@endsection