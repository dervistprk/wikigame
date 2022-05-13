@extends('layouts.app')
@section('title', 'Makaleler')
@section('content')
    <div class="container">
        <h2 class="game-header">Makaleler</h2>
        <div class="d-inline-block mt-2 float-end sticky-top" style="max-width: 520px; z-index: 97; top: 4em">
            <div class="list-group">
                <div class="d-flex w-100 justify-content-between">
                    <h3 class="game-header p-2">En Çok Okunanlar</h3>
                </div>
                @if($popular_articles)
                    @foreach($popular_articles as $popular_article)
                        <a href="{{ route('article', $popular_article->slug) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $popular_article->title }}</h6>
                                <small>{{ \Carbon\Carbon::parse($popular_article->created_at)->diffForHumans() }}</small>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
        @include('frontend.lists.articles')
    </div>
@endsection