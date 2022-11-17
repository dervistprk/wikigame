@extends('layouts.app')
@section('title', __('Hata'))
@section('content')
    <div class="container">
        <div class="game-info p-3 rounded" style="margin: 15%">
            <h2 class="dev-header text-center">{{ __('Sunucu Cevap Vermiyor') }}</h2>
            <h3 class="dev-header text-center">Code: 500</h3>
            <h5 class="dev-header text-center">{{ __('Lütfen daha sonra tekrar deneyin.') }}</h5>
        </div>
    </div>
@endsection

