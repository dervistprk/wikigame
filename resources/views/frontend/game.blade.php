@extends('layouts.app')
@section('title', isset($game->name) ? $game->name : 'Kayıtlı Oyun Bulunamadı')
@section('content')
    <div class="container">
        @if($errors->any())
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="alert alert-danger alert-dismissible fade show">
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
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
                                <div class="mb-3 submit-comment-layout">
                                    <button type="submit" class="btn btn-sm btn-warning float-end submit-comment">Gönder</button>
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

             $('.delete-comment-button').on('click', function() {
                var confirm_text = 'Yorumu Silmek İstediğinizden Emin misiniz?';
                if (confirm(confirm_text)) {
                   var comment_div;
                   var current_comment = $(this);
                   var comment_id      = current_comment.attr('data-id');
                   $.ajax({
                      url       : "{{ route('user-delete-game-comment') }}",
                      type      : 'POST',
                      data      : {
                         comment_id: comment_id,
                      },
                      headers   : {
                         'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                      },
                      beforeSend: function() {
                         flasher.info('Yorum Siliniyor Lütfen Bekleyin <i class="fas fa-spin fa-spinner"></i>', 'Yükleniyor');
                      },
                      success   : function(response) {
                         if (response.is_sub_comment) {
                            comment_div = $(current_comment).parents('.subcomment-layout');
                         } else {
                            comment_div = $(current_comment).parents('.parent-comment-layout');
                         }
                         $(comment_div).fadeOut('normal', function() {
                            $(this).remove();
                         });
                         flasher.success(response.flasher_message, 'Başarılı');
                         if (response.reload) {
                            setTimeout(function() {
                               location.reload();
                            }, 2500);
                         }
                      },
                      error     : function(xhr, status, error) {
                         flasher.error('Yorum Silinirken Hata Oluştu', 'Hata');
                         console.log(xhr.responseText);
                         console.log(status);
                         console.log(error);
                      },
                   });
                }
             });

             $('.like-comment-button').on('click', function() {
                var current_comment = $(this);
                var comment_id      = current_comment.attr('data-id');
                $.ajax({
                   url       : "{{ route('user-like-game-comment') }}",
                   type      : 'POST',
                   data      : {
                      comment_id: comment_id,
                   },
                   headers   : {
                      'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                   },
                   beforeSend: function() {
                      flasher.info('Lütfen Bekleyin <i class="fas fa-spin fa-spinner"></i>', 'Yükleniyor');
                   },
                   success   : function() {
                      flasher.success('Yorum Başarıyla Beğenildi', 'Başarılı');
                      setTimeout(function() {
                         location.reload();
                      }, 3000);
                   },
                   error     : function(xhr, status, error) {
                      flasher.error('Yorum Beğenilirken Hata Oluştu', 'Hata');
                      console.log(xhr.responseText);
                      console.log(status);
                      console.log(error);
                   },
                });
             });

             $('.dislike-comment-button').on('click', function() {
                var current_comment = $(this);
                var comment_id      = current_comment.attr('data-id');
                $.ajax({
                   url       : "{{ route('user-dislike-game-comment') }}",
                   type      : 'POST',
                   data      : {
                      comment_id: comment_id,
                   },
                   headers   : {
                      'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                   },
                   beforeSend: function() {
                      flasher.info('Lütfen Bekleyin <i class="fas fa-spin fa-spinner"></i>', 'Yükleniyor');
                   },
                   success   : function() {
                      flasher.success('Yorum Başarıyla Eksilendi', 'Başarılı');
                      setTimeout(function() {
                         location.reload();
                      }, 3000);
                   },
                   error     : function(xhr, status, error) {
                      flasher.error('Yorum Eksilenirken Hata Oluştu', 'Hata');
                      console.log(xhr.responseText);
                      console.log(status);
                      console.log(error);
                   },
                });
             });
          }

          $('.submit-comment').on('click', function(e) {
             var comment_length = stripTags($('#comment').val()).trim().length;
             if (comment_length < 30) {
                $('.min-char-alert').remove();
                e.preventDefault();
                $('.submit-comment-layout').append(
                    '<div class="alert alert-danger col-sm-6 float-start min-char-alert">Lütfen en az <strong>30</strong> karakter uzunluğunda bir yorum giriniz.</div>');
                $('.min-char-alert').effect('shake');
             }
          });

          $('.submit-edit').on('click', function(e) {
             var comment_length = stripTags($(this).parents('.edit-comment-layout').prev('.edit-text-layout').find(
                 '.edit-comment-text').val()).trim().length;
             if (comment_length < 30) {
                $(this).siblings('.min-char-alert-edit').remove();
                e.preventDefault();
                $(this).parents('.edit-comment-layout').append(
                    '<div class="alert alert-danger col-sm-9 float-start min-char-alert-edit">Lütfen en az <strong>30</strong> karakter uzunluğunda bir yorum giriniz.</div>');
                $(this).siblings('.min-char-alert-edit').effect('shake');
             }
          });

          $('.submit-reply').on('click', function(e) {
             var comment_length = stripTags($(this).parents('.reply-comment-layout').prev('.reply-text-layout').find(
                 '.reply-comment-text').val()).trim().length;
             if (comment_length < 30) {
                $(this).siblings('.min-char-alert-reply').remove();
                e.preventDefault();
                $(this).parents('.reply-comment-layout').append(
                    '<div class="alert alert-danger col-sm-9 float-start min-char-alert-reply">Lütfen en az <strong>30</strong> karakter uzunluğunda bir yorum giriniz.</div>');
                $(this).siblings('.min-char-alert-reply').effect('shake');
             }
          });

          function stripTags(html) {
             var tmp       = document.createElement('DIV');
             tmp.innerHTML = html;
             return tmp.textContent || tmp.innerText;
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

