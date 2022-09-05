@extends('layouts.app')
@section('title', 'Tüm Oyunlar')
@section('content')
    <div class="container">
        @if($games->count() > 0)
            <h2 class="game-header">Tüm Oyunlar</h2>
            @include('frontend.lists.games')
        @else
            <div class="alert alert-secondary text-center m-2">
                Sistemde kayıtlı oyun bulunamadı.
            </div>
        @endif
    </div>
@endsection
