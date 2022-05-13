@extends('layouts.app')
@section('title', 'Dağıtıcılar')
@section('content')
    @if(isset($publishers))
        <div class="container">
            @foreach($publishers as $publisher)
                <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $publisher->name }}">
                    <div class="card">
                        <img class="card-img-top lazyload" data-src="{{ $publisher->image }}" src="{{ asset('assets/preview-image-big.png') }}" alt="{{ $publisher->name }}" title="{{ $publisher->name }}" width="300" height="220" loading="lazy">
                        <div class="card-body">
                            <h6 class="card-title">{{ $publisher->name }}</h6>
                            <a href="{{ route('publisher', [$publisher->slug]) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="margin: 15px 0 0 17px;">{{ $publishers->links() }}</div>
    @else
        <div class="alert alert-danger m-2">
            Sistemde kayıtlı dağıtıcı bulunamadı.
        </div>
    @endif
@endsection
