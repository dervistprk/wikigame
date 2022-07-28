@extends('layouts.app')
@section('title', isset($game->name) ? $game->name : 'Kayıtlı Oyun Bulunamadı')
@section('content')
    <div class="container">
        @if(isset($game))
            <div>
                <h2 class="game-header">{{$game->name}}</h2>
                <div style="margin: 0 100px 0 100px">
                    @include('frontend.carousel')
                </div>
                <div class="game-info m-3 p-3 rounded">
                    <h5 class="game-subtitle">{{$game->sub_title}}</h5>
                    <p>{!! $game->description !!}</p>
                </div>
                <div style="margin-left: 15px; width: 75%">
                    @include('frontend.game_details')
                </div>
                <div>
                    <div style="margin-left: 15px; width: 75%">
                        <h3 class="sysreq-header">Minimum Sistem Gereksinimleri</h3>
                        @include('frontend.system_requirements_minimum')
                    </div>
                    <div style="margin-left: 15px; width: 75%">
                        <h3 class="sysreq-header">Önerilen Sistem Gereksinimleri</h3>
                        @include('frontend.system_requirements_recommended')
                    </div>
                </div>
            </div>
            <div>
                <h2 class="game-header">{{ $game->category->name }} Kategorisinde Popüler</h2>
                @if($other_games->count() > 0)
                    @foreach($other_games as $other)
                        <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $other->name }}">
                            <div class="card">
                                <img class="card-img-top lazyload" data-src="{{$other->cover_image}}" src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $other->name }}" title="{{ $other->name }}" width="220" height="300" loading="lazy">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $other->name }}</h6>
                                    <a href="{{ route('game', [$other->slug]) }}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-secondary text-center">
                        <p>{{ $game->category->name }} kategorisinde başka oyun bulunmamaktadır.</p>
                    </div>
                @endif
            </div>
        @else
            <div class="alert alert-danger m-2">
                Sistemde kayıtlı oyun bulunamadı.
            </div>
        @endif
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#prev').on('click', function () {
                $('#carouselBasicExample').carousel('prev');
            });
            $('#next').on('click', function () {
                $('#carouselBasicExample').carousel('next');
            });
            $('#carouselBasicExample').carousel('pause');
        });
    </script>
@endsection

@section('redirect-js')
    <script type="text/javascript">
        var uri = window.location.pathname;
        if (uri == '/rastgele-oyun') {
            window.location.replace('/oyun/{{ $game->slug }}');
        }
    </script>
@endsection

