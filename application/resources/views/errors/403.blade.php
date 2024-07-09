@extends('layouts.app')
@section('title', __('Hata'))
@section('content')
    <div class="container">
        <div class="game-info p-3 rounded" style="margin: 15%">
            <h2 class="dev-header text-center">{{ __('Aradığınız Sayfa Erişilemez') }}</h2>
            <h3 class="dev-header text-center">Code: 403</h3>
            <h5 class="dev-header text-center">{{ __('Ulaşmaya çalıştığınız sayfa erişime kapalıdır.') }}</h5>
        </div>
    </div>
@endsection

