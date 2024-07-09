@extends('layouts.app')
@section('title', $publisher->name .' ' .  __('Dağıtıcı Bilgileri') )
@section('content')
    <div class="container">
        <div>
            <img src="{{ $publisher->image }}" alt="developer_resmi" height="75" width="100"
                 class="img-fluid img-thumbnail m-2" title="{{ $publisher->name }}">
            <h2 class="pub-header d-inline-block">{{ $publisher->name }}</h2>
            <div class="game-info p-3 mt-2 mb-2">
                <h4 class="game-subtitle">{{ __('Dağıtıcı Bilgileri') }}</h4>
                <p>{!! $publisher->description !!}</p>
            </div>
        </div>
        <h2 class="pub-header text-center">{{ __('Dağıtıcıya Ait Oyunlar') }}</h2>
        @foreach($games as $game)
            <div class="card-deck d-inline-block m-2 game-card" title="{{ $game->name }}">
                <div class="card content-cards">
                    <img class="card-img-top img-fluid" src="{{$game->cover_image}}" alt="{{ $game->name }}"
                         title="{{ $game->name }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $game->name }}</h6>
                        <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        @endforeach
        @if(count($games) == 0)
            <div class="alert alert-secondary text-center">{{ __('Dağıtıcıya Ait Oyun Bulunamadı.') }}</div>
        @endif
        <div class="m-2">{{ $games->links() }}</div>
    </div>
@endsection
