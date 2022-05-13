@extends('layouts.app')
@section('title', $developer->name.' Geliştirici Bilgileri')
@section('content')
    <div class="container">
        <div>
            <img src="{{ $developer->image }}" alt="developer_resmi" height="75" width="100" class="m-2" title="{{ $developer->name }}">
            <h2 class="dev-header d-inline-block">{{ $developer->name }}</h2>
            <div class="game-info" style="padding: 10px; margin: 15px;">
                <h4 class="game-subtitle">Geliştirici Bilgileri</h4>
                <p>{!! $developer->description !!}</p>
            </div>
        </div>
        <h2 class="dev-header">Geliştiriciye Ait Oyunlar</h2>
        @foreach($games as $game)
            <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $game->name }}">
                <div class="card">
                    <img class="card-img-top" src="{{$game->cover_image}}" alt="{{ $game->name }}" title="{{ $game->name }}" width="220" height="300">
                    <div class="card-body">
                        <h6 class="card-title">{{ $game->name }}</h6>
                        <a href="{{ route('game', [$game->slug]) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        @endforeach
        @if(count($games) == 0)
            <div class="alert alert-secondary text-center">Geliştiriciye Ait Oyun Bulunamadı.</div>
        @endif
        <div style="margin: 15px 0 0 17px;">{{ $games->links() }}</div>
    </div>
@endsection
