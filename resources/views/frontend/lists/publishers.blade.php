@extends('layouts.app')
@section('title', __('Dağıtıcılar'))
@section('content')
    <div class="container">
        @if($publishers->count() > 0)
            <h2 class="pub-header">
                {{ __('Dağıtıcılar') }}
            </h2>
            @foreach($publishers as $publisher)
                <div class="card-deck d-inline-block m-2" title="{{ $publisher->name }}">
                    <div class="card content-cards">
                        <img class="card-img-top img-fluid img-thumbnail lazyload" data-src="{{ $publisher->image }}"
                             src="{{ asset('assets/preview-image-big.png') }}" alt="{{ $publisher->name }}"
                             title="{{ $publisher->name }}" width="300" height="220" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $publisher->name }}</h6>
                            <a href="{{ route('publisher', [$publisher->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="m-1">{!! $publishers->links() !!}</div>
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı dağıtıcı bulunamadı.') }}
            </div>
        @endif
    </div>
@endsection
