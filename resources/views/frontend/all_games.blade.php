@extends('layouts.app')
@section('title', __('Tüm Oyunlar'))
@section('content')
    <div class="container">
        @if($games->count() > 0)
            <h2 class="game-header">{{ __('Tüm Oyunlar') }}</h2>
            @include('frontend.lists.games')
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı oyun bulunamadı.') }}
            </div>
        @endif
    </div>
@endsection
