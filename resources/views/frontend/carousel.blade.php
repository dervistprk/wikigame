<!-- Carousel wrapper -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><span></span></button>
        @for($i = 1; $i <= $game->images->count() + $game->videos->count(); $i++)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}" aria-label="Slide {{ $i + 1 }}"><span></span></button>
        @endfor
    </div>
    <!-- Inner -->
    <div class="carousel-inner">
        @foreach($game->videos as $video)
            <div id="game-video" class="carousel-item @if($loop->first) active @endif">
                <iframe id="game-video-{{ $video_count }}" class="d-block w-100 img-fluid min-vh-100" src="{{ $video->url }}?enablejsapi=1" allowfullscreen></iframe>
            </div>
            @php $video_count++; @endphp
        @endforeach
        <div class="carousel-item">
            <img src="{{ $game->image1 }}" class="d-block w-100 img-fluid" alt="{{ $game->name }}">
        </div>
        @foreach($game->images as $image)
            <div class="carousel-item">
                <img src="{{ $image->path }}" class="d-block w-100 img-fluid" alt="{{ $game->name }}">
            </div>
        @endforeach
    </div>
    <!-- Controls -->
    <button class="carousel-control-prev" id="prev-button" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <i class="fa fa-3x text-warning fa-arrow-alt-circle-left"></i>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" id="next-button" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <i class="fa fa-3x text-warning fa-arrow-alt-circle-right"></i>
        <span class="visually-hidden">Next</span>
    </button>
</div>
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
          console.log(players);
          $('#carouselExampleIndicators').on('slide.bs.carousel', function(event) {
             if (players[event.from] !== undefined) {
                players[event.from].pauseVideo();
             }
          });
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
                     'onStateChange': onPlayerStateChange
                  }
               }
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
    </script>
@endsection
