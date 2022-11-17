@extends('layouts.app')
@section('title', __('Geliştiriciler'))
@section('content')
    <div class="container">
        @if($developers->count() > 0)
            <h2 class="dev-header">
                {{ __('Geliştiriciler') }}
            </h2>
            @foreach($developers as $developer)
                <div class="card-deck d-inline-block m-2" title="{{ $developer->name }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid img-thumbnail lazyload" data-src="{{ $developer->image }}"
                             src="{{ asset('assets/preview-image-big.png') }}" alt="{{ $developer->name }}"
                             title="{{ $developer->name }}" width="300" height="220" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $developer->name }}</h6>
                            <a href="{{ route('developer', [$developer->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="m-1">{!! $developers->links() !!}</div>
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı geliştirici bulunamadı.') }}
            </div>
        @endif
    </div>
@endsection
