@extends('layouts.app')
@section('title', __('Hata'))
@section('content')
    <div class="container">
        <div class="game-info p-3 rounded" style="margin: 15%">
            <h2 class="dev-header text-center">{{ __('Yetkisiz Giriş Tespit Edildi') }}</h2>
            <h3 class="dev-header text-center">Code: 401</h3>
            <h5 class="dev-header text-center">{{ __('Ulaşmaya çalıştığınız sayfaya erişim izninizin olduğunu doğrulayıp lütfen tekrar deneyin.') }}</h5>
        </div>
    </div>
@endsection

