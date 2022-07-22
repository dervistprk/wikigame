<!-- Carousel wrapper -->
<div id="carouselBasicExample" class="carousel slide carousel-fade" data-ride="carousel">
    <!-- Controls -->
    <button id="prev" class="carousel-control-prev fontIcon rounded-circle" type="button" data-target="#carouselBasicExample" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button id="next" class="carousel-control-next fontIcon rounded-circle" type="button" data-target="#carouselBasicExample" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carouselBasicExample" class="active" data-slide-to="0"></li>
        @if(($game->video2))
            <li data-target="#carouselBasicExample" data-slide-to="1"></li>
        @endif
        @if(($game->video3))
            <li data-target="#carouselBasicExample" data-slide-to="2"></li>
        @endif
        @if(($game->video4))
            <li data-target="#carouselBasicExample" data-slide-to="3"></li>
        @endif
        @if(($game->video5))
            <li data-target="#carouselBasicExample" data-slide-to="4"></li>
        @endif
        <li data-target="#carouselBasicExample" data-slide-to="5"></li>
        @if(($game->image2))
            <li data-target="#carouselBasicExample" data-slide-to="6"></li>
        @endif
        @if(($game->image3))
            <li data-target="#carouselBasicExample" data-slide-to="7"></li>
        @endif
        @if(($game->image4))
            <li data-target="#carouselBasicExample" data-slide-to="8"></li>
        @endif
        @if(($game->image5))
            <li data-target="#carouselBasicExample" data-slide-to="9"></li>
        @endif
        @if(($game->image6))
            <li data-target="#carouselBasicExample" data-slide-to="11"></li>
        @endif
        @if(($game->image7))
            <li data-target="#carouselBasicExample" data-slide-to="12"></li>
        @endif
    </ol>
    <!-- Inner -->
    <div class="carousel-inner embed-responsive embed-responsive-16by9">
        <div class="carousel-item embed-responsive-item active">
            <iframe id="video1" src="{{ $game->video1 }}" title="{{ $game->name }} Video" class="d-block" allowfullscreen></iframe>
        </div>
        @if(($game->video2))
            <div class="carousel-item embed-responsive-item">
                <iframe id="video2" src="{{ $game->video2 }}" title="{{ $game->name }} Video2" class="d-block" allowfullscreen></iframe>
            </div>
        @endif
        @if(($game->video3))
            <div class="carousel-item embed-responsive-item">
                <iframe id="video3" src="{{ $game->video3 }}" title="{{ $game->name }} Video3" class="d-block" allowfullscreen></iframe>
            </div>
        @endif
        @if(($game->video4))
            <div class="carousel-item embed-responsive-item">
                <iframe id="video4" src="{{ $game->video4 }}" title="{{ $game->name }} Video4" class="d-block" allowfullscreen></iframe>
            </div>
        @endif
        @if(($game->video5))
            <div class="carousel-item embed-responsive-item">
                <iframe id="video5" src="{{ $game->video5 }}" title="{{ $game->name }} Video5" class="d-block" allowfullscreen></iframe>
            </div>
        @endif
        <div class="carousel-item embed-responsive-item">
            <img src="{{ $game->image1 }}" class="d-block" alt="{{ $game->name }} Resim1" title="{{ $game->name }}"/>
        </div>
        @if(($game->image2))
            <div class="carousel-item embed-responsive-item">
                <img src="{{ $game->image2 }}" class="d-block" alt="{{ $game->name }} Resim2" title="{{ $game->name }}"/>
            </div>
        @endif
        @if(($game->image3))
            <div class="carousel-item embed-responsive-item">
                <img src="{{ $game->image3 }}" class="d-block" alt="{{ $game->name }} Resim3" title="{{ $game->name }}"/>
            </div>
        @endif
        @if(($game->image4))
            <div class="carousel-item embed-responsive-item">
                <img src="{{ $game->image4 }}" class="d-block" alt="{{ $game->name }} Resim4" title="{{ $game->name }}"/>
            </div>
        @endif
        @if(($game->image5))
            <div class="carousel-item embed-responsive-item">
                <img src="{{ $game->image5 }}" class="d-block" alt="{{ $game->name }} Resim5" title="{{ $game->name }}"/>
            </div>
        @endif
        @if(($game->image6))
            <div class="carousel-item embed-responsive-item">
                <img src="{{ $game->image6 }}" class="d-block" alt="{{ $game->name }} Resim6" title="{{ $game->name }}"/>
            </div>
        @endif
        @if(($game->image7))
            <div class="carousel-item embed-responsive-item">
                <img src="{{ $game->image7 }}" class="d-block" alt="{{ $game->name }} Resim7" title="{{ $game->name }}"/>
            </div>
        @endif
    </div>
</div>

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

@section('custom-css')
    <style>
        #carouselBasicExample {
            margin-left: 50px;
            margin-right: 50px;
            width: 1000px;
            height: 600px;
        }

        #carouselBasicExample iframe {
            width: 1000px;
            height: 560px;
        }

        .fontIcon {
            height: 35px;
            width: 35px;
            background-color: black;
            border-radius: 15px;
        }

        .carousel-item img {
            width: 1000px;
            height: 560px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background: orangered;
            border: none;
            margin-left: -60px;
            margin-right: -60px;
            margin-top: 280px;
        }

        .carousel .carousel-indicators li {
            background-color: orangered;
        }

        .carousel .carousel-indicators li.active {
            background-color: yellow;
        }
    </style>
@endsection
