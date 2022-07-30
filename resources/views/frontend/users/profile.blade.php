@extends('layouts.app')
@section('title', 'Profil')
@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success m-2">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="btn-group h-100 d-flex align-items-center justify-content-center" role="group">
            <a type="button" class="btn btn-primary btn-lg" href=" {{route('update-profile')}}">Profil Bilgilerimi Güncelle</a>
            <a type="button" class="btn btn-danger btn-lg" href="#">Şifremi Güncelle</a>
            <a type="button" class="btn btn-warning btn-lg" href="#">Yorumlarım</a>
        </div>
    </div>
@endsection