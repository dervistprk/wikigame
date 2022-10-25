@extends('layouts.app')
@section('title', 'Makaleler')
@section('content')
    <div class="container">
        @if($articles->count() > 0)
            <h2 class="game-header">Makaleler</h2>
            <div class="row">
                <div class="col">
                    <div class="list-group">
                        <div class="d-flex w-100 justify-content-between">
                            <h3 class="game-header p-2">En Çok Okunanlar</h3>
                        </div>
                        @if($popular_articles->count() > 0)
                            @foreach($popular_articles as $popular_article)
                                <a href="{{ route('article', $popular_article->slug) }}"
                                   class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 w-75">{{ $popular_article->title }}</h6>
                                        <small>{{ \Carbon\Carbon::parse($popular_article->created_at)->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="list-group">
                        <div class="d-flex w-100 justify-content-between">
                            <h3 class="game-header p-2">Sizin İçin Seçtiklerimiz</h3>
                        </div>
                        @if($random_articles->count() > 0)
                            @foreach($random_articles as $random_article)
                                <a href="{{ route('article', $random_article->slug) }}"
                                   class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 w-75">{{ $random_article->title }}</h6>
                                        <small>{{ \Carbon\Carbon::parse($random_article->created_at)->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @include('frontend.lists.articles')
        @else
            <div class="alert alert-secondary text-center m-2">
                Sistemde kayıtlı makale bulunamadı.
            </div>
        @endif
    </div>
@endsection
