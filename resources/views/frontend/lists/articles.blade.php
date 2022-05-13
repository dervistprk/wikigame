@foreach($articles as $article)
    <div class="card-deck" style="margin: 10px; display: inline-block" title="{{ $article->title }}">
        <div class="card" style="max-width: 720px">
            <img class="card-img-top lazyload" data-src="{{$article->image}}" src="{{ asset('assets/preview-image-large.png') }}" alt="{{ $article->title }}" title="{{ $article->title }}" width="640" height="480" loading="lazy">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <p class="card-text">{{ $article->sub_title }}</p>
                <a href="{{ route('article', [$article->slug]) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
@endforeach
<div style="margin: 15px 0 0 17px;">{{ $articles->links() }}</div>

