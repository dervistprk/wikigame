@extends('layouts.app')
@section('title', trans('titles.category_title', ['category' => $game_category->name]))
@section('content')
    <div class="container">
        <div>
            <h2 class="category-header">{{ trans('titles.category_title', ['category' => $game_category->name]) }}</h2>
            <div class="game-info mt-2 mb-2 p-3 rounded">
                <h5 class="game-subtitle">{{ __('Kategori Açıklaması') }}</h5>
                <p>{!! $game_category->description !!}</p>
            </div>
        </div>
        @if($games->count() > 0)
            <h2 class="category-header">{{ trans('titles.category_subgames_title', ['category' => $game_category->name]) }}</h2>
            @foreach($games as $game)
                <div class="card-deck d-inline-block m-2" title="{{ $game->name }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid" src="{{$game->cover_image}}" alt="{{ $game->name }}"
                             title="{{ $game->name }}" width="100" height="300">
                        <div class="card-body">
                            <h6 class="card-title">{{ $game->name }}</h6>
                            <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="m-1">{{ $games->links() }}</div>
    </div>
@endsection
