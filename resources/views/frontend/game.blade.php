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
            <h3 class="game-header mt-2">Yorumlar</h3>
            <div class="game-info p-3 mt-3">
                @if($game->parentComments->count() > 0)
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="card comment-card">
                                <div class="card-body">
                                    @foreach($game->parentComments as $comment)
                                        @include('frontend.game_comments.game_comments')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="alert alert-warning">
                            Henüz yorum yapılmamış. İlk yorumu sen yap!
                        </div>
                    </div>
                @endif
                <hr>
                @if(\Auth::user())
                    <div class="row">
                        <div class="col-sm-9 col-md-9 col-lg-9 ms-2">
                            <form method="post" action="{{ route('user-make-game-comment', $game->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="comment" class="form-label fw-bold">Yorum Yaz</label>
                                    <textarea class="form-control comment-text" name="comment" id="comment" rows="5" placeholder="Yorum giriniz" minlength="30" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-sm btn-warning float-end">Gönder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center mt-2">
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
                            <div class="card content-cards">
                                <img class="card-img-top img-fluid lazyload" data-src="{{ $other->cover_image }}" src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $other->name }}" title="{{ $other->name }}" width="220" height="300" loading="lazy">
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
          $('#carouselExampleIndicators').on('slide.bs.carousel', function(event) {
             if (players[event.from] !== undefined) {
                players[event.from].pauseVideo();
             }
          });

          var tag            = document.createElement('script');
          tag.src            = 'https://www.youtube.com/iframe_api';
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
          var players = [];

          function onYouTubeIframeAPIReady() {
             var allMovieIframes = document.getElementById('carouselExampleIndicators').getElementsByTagName('iframe');
             let currentIFrame;
             for (currentIFrame of allMovieIframes) {
                players.push(new YT.Player(
                    currentIFrame.id,
                    {
                       events: {
                          'onStateChange': onPlayerStateChange,
                       },
                    },
                ));
             }
          }

          function onPlayerStateChange(event) {
             var carousel = $('#carouselExampleIndicators');
             if (event.data == YT.PlayerState.PLAYING || event.data == YT.PlayerState.BUFFERING) {
                carousel.children('.carousel-control-prev').hide();
                carousel.children('.carousel-control-next').hide();
                carousel.children('.carousel-indicators').hide();
                carousel.carousel('pause');
             } else {
                carousel.children('.carousel-control-prev').show();
                carousel.children('.carousel-control-next').show();
                carousel.children('.carousel-indicators').show();
                carousel.carousel();
             }
          }

          var comment_total = {{ $game->comments->count() }};

          if (comment_total > 0) {
             $('.reply-comment-button').on('click', function() {
                $(this).siblings('.reply-form').fadeIn();
             });

             $('.close-reply-form-button').on('click', function() {
                $(this).parents('.reply-form').fadeOut();
             });

             $('.edit-comment-button').on('click', function() {
                $(this).siblings('.edit-form').fadeIn();
                $(this).siblings('.comment-body').fadeOut();
             });

             $('.close-edit-form-button').on('click', function() {
                $(this).parents('.edit-form').fadeOut(300);
                $(this).parents('.edit-form').next('.comment-body').fadeIn(600);
             });
          }
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

