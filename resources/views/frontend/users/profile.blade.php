@extends('layouts.app')
@section('title', __('Profil'))
@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-warning m-2 alert-dismissible fade show">
                {!! session()->get('message') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h3 class="game-header">{{ trans('messages.welcome_message', ['name' => $user->name, 'surname' => $user->surname]) }}</h3>
        <div class="game-info m-3 p-3 rounded">
            @if(\Auth::user()->isAdmin())
                <span class="badge bg-secondary float-end">{{ __('Yönetici Hesabı') }}</span>
                <a class="btn btn-sm btn-warning mb-2 @if($ip_check_message) disabled @endif" target="_blank"
                   href="{{ route('admin.dashboard') }}"><i class="fa fa-user-cog"></i> {{ __('Yönetici Paneli') }}</a>
                @if($ip_check_message)
                    <span class="text-danger">{{ $ip_check_message }}</span>
                @endif
            @endif
            <p>
                {!! trans('messages.profile_panel_message') !!}
            </p>
        </div>
        <div class="btn-group h-100 d-flex align-items-center justify-content-center mt-2" role="group">
            <a type="button" class="btn btn-primary btn-lg" href=" {{ route('update-profile')}} ">{{ __('Bilgilerim') }}</a>
            <a type="button" class="btn btn-danger btn-lg" href="#">{{ __('Favorilerim') }}</a>
            <a type="button" class="btn btn-info btn-lg" href="{{ route('user-comments') }}">{{ __('Yorumlarım') }}</a>
        </div>
    </div>
@endsection
