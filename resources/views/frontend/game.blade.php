@extends('layouts.app')
@section('title', isset($game->name) ? $game->name : 'Kayıtlı Oyun Bulunamadı')
@section('content')
    <div class="container">
        @if(isset($game))
            <h2 class="game-header">{{ $game->name }}</h2>
            <div class="justify-content-center align-content-center d-flex h-100">
                @include('frontend.carousel')
            </div>
            <div class="game-info mt-3 mb-3 p-3 rounded">
                <h5 class="game-subtitle">{{ $game->sub_title }}</h5>
                <p>{!! $game->description !!}</p>
            </div>
            @include('frontend.game_details')
            <div class="row mt-2">
                <div class="col">
                    <h3 class="sysreq-header">Minimum Sistem Gereksinimleri</h3>
                    @include('frontend.system_requirements_minimum')
                </div>
                <div class="col">
                    <h3 class="sysreq-header">Önerilen Sistem Gereksinimleri</h3>
                    @include('frontend.system_requirements_recommended')
                </div>
            </div>
            <h3 class="game-header">Yorumlar</h3>
            <div class="game-info p-3 mt-3">
                <div>
                    @if($game->comments->count() > 0)
                        @foreach($game->comments as $comment)

                        @endforeach
                    @else
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="alert alert-warning">
                                Henüz yorum yapılmamış. İlk yorumu sen yap!
                            </div>
                        </div>
                    @endif
                </div>
                @if(\Auth::user())
                    <form method="post" action="#">
                        <div class="col-sm-6 mb-3">
                            <label for="comment" class="form-label">Yorum Yap</label>
                            <textarea class="form-control" id="comment" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-warning">Yorum Yap</button>
                        </div>
                    </form>
                @else
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="alert alert-warning">
                            Yorum yapabilmek için lütfen
                            <a href="{{ route('login-form') }}" class="register-login-link text-decoration-none">giriş yap</a> veya
                            <a href="{{ route('register-form') }}" class="register-login-link text-decoration-none">üye ol</a>.
                        </div>
                    </div>
                @endif
            </div>
            @if($other_games->count() > 0)
                <div class="mt-2">
                    <h2 class="game-header text-center">{{ $game->category->name }} Kategorisinde Popüler</h2>
                    @foreach($other_games as $other)
                        <div class="card-deck d-inline-block m-2" title="{{ $other->name }}">
                            <div class="card">
                                <img class="card-img-top img-fluid lazyload" data-src="{{$other->cover_image}}" src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $other->name }}" title="{{ $other->name }}" width="220" height="300" loading="lazy">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $other->name }}</h6>
                                    <a href="{{ route('game', [$other->slug]) }}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <div class="alert alert-secondary text-center m-2">
                Sistemde kayıtlı oyun bulunamadı.
            </div>
        @endif
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
          $('#prev').on('click', function() {
             $('#carouselBasicExample').carousel('prev');
          });
          $('#next').on('click', function() {
             $('#carouselBasicExample').carousel('next');
          });
          $('#carouselBasicExample').carousel('pause');
       });
    </script>
@endsection

@section('redirect-js')
    <script type="text/javascript">
       var uri = window.location.pathname;
       @if(isset($game))
       if (uri == '/rastgele-oyun') {
          window.location.replace('/oyun/{{ $game->slug }}');
       }
        @endif
    </script>
@endsection

