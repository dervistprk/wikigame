@extends('layouts.app')
@section('title', 'Dağıtıcılar')
@section('content')
    @if(isset($publishers))
        <div class="container">
            <h2 class="pub-header">
                Dağıtıcılar
            </h2>
            @foreach($publishers as $publisher)
                <div class="card-deck d-inline-block m-2" title="{{ $publisher->name }}">
                    <div class="card">
                        <img class="card-img-top img-fluid lazyload" data-src="{{ $publisher->image }}" src="{{ asset('assets/preview-image-big.png') }}" alt="{{ $publisher->name }}" title="{{ $publisher->name }}" width="300" height="220" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $publisher->name }}</h6>
                            <a href="{{ route('publisher', [$publisher->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="m-1">{{ $publishers->links() }}</div>
    @else
        <div class="alert alert-danger m-2">
            Sistemde kayıtlı dağıtıcı bulunamadı.
        </div>
    @endif
@endsection
