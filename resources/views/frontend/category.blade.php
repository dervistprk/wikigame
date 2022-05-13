@extends('layouts.app')
@section('title', $game_category->name.' Kategorisi')
@section('content')
    <div class="container">
        <div>
            <h2 class="category-header">{{ $game_category->name }} Kategorisi</h2>
            <div class="game-info m-3 p-3 rounded">
                <h5 class="game-subtitle">Kategori Açıklaması</h5>
                <p>{!! $game_category->description !!}</p>
            </div>
        </div>
        <h2 class="category-header">{{ $game_category->name }} Kategorisine Ait Oyunlar</h2>
        @foreach($games as $game)
            <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $game->name }}">
                <div class="card">
                    <img class="card-img-top" src="{{$game->cover_image}}" alt="{{ $game->name }}" title="{{ $game->name }}" width="100" height="300">
                    <div class="card-body">
                        <h6 class="card-title">{{ $game->name }}</h6>
                        <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        @endforeach
        @if(count($games) == 0)
            <div class="alert alert-secondary text-center">{{ $game_category->name }} Kategorisine Ait Oyun Bulunamadı.</div>
        @endif
        <div style="margin: 15px 0 0 17px;">{{ $games->links() }}</div>
    </div>
@endsection
