@foreach($articles as $article)
    <div class="card-deck d-inline-block m-3 d-flex align-items-center justify-content-center" title="{{ $article->title }}">
        <div class="card content-cards" style="max-width:75%">
            <img class="card-img-top lazyload img-fluid" data-src="{{$article->image}}" src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $article->title }}" title="{{ $article->title }}" width="640" height="480" loading="lazy">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <p class="card-text">{{ $article->sub_title }}</p>
                <a href="{{ route('article', [$article->slug]) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
@endforeach
<div class="m-1">{!! $articles->links() !!}</div>

