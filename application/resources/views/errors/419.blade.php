@extends('layouts.app')
@section('title', __('Hata'))
@section('content')
    <div class="container">
        <div class="game-info p-3 rounded" style="margin: 15%">
            <h2 class="dev-header text-center">{{ __('Oturum Süreniz Doldu') }}</h2>
            <h3 class="dev-header text-center">Code: 419</h3>
            <h5 class="dev-header text-center">{{ __('İşleminize devam edebilmek için lütfen oturum açınız.') }}</h5>
        </div>
    </div>
@endsection

