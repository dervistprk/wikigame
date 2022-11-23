@extends('layouts.app')
@section('title', __('Yorumlarım'))
@section('content')
<div class="container">
    @if(session()->has('message'))
        <div class="alert alert-warning m-2 alert-dismissible fade show">
            {!! session()->get('message') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <div class="btn-group h-100 d-flex align-items-center justify-content-center mt-2" role="group">
            <a type="button" class="btn btn-primary btn-lg" href=" {{ route('update-profile')}} ">{{ __('Bilgilerim') }}</a>
            <a type="button" class="btn btn-danger btn-lg" href="#">{{ __('Favorilerim') }}</a>
            <a type="button" class="btn btn-info btn-lg active" href="{{ route('user-comments') }}" style="pointer-events: none">{{ __('Yorumlarım') }}</a>
        </div>
        <div class="my-3">
            <h2 class="dev-header mt-2 d-inline-block">{{ __('Yorumlarım') }}</h2>
            <form action="{{ route('user-comments') }}" method="get" class="d-inline-block float-end mb-4" id="sort_form">
                @csrf
                <label for="sort_by" class="form-label fw-bold">Sırala</label>
                <select class="form-control form-select-sm" name="sort_by" id="sort_by">
                    @foreach($order_by_values as $key => $value)
                        <option value="{{ $key }}" @if(Request::get('sort_by') == $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="sort_dir" id="sort_dir">
            </form>
        </div>
        <div class="game-info">
            @foreach($comments as $comment)
                <div class="commentable p-2 m-2 d-flex">
                    <div class="d-inline-block">
                        <h4 class="game-subtitle">{{ __('Yorum Yapılan İçerik') }}</h4>
                        <div class="card-deck d-inline-block m-1" title="{{ $comment->commentable->name }}">
                            <div class="card content-cards">
                                <img class="card-img-top img-fluid lazyload" data-src="{{ $comment->commentable->cover_image }}"
                                     src="{{ asset('assets/preview-image-game.png') }}" alt="{{ $comment->commentable->name }}" title="{{ $comment->commentable->name }}"
                                     loading="lazy">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $comment->commentable->name }}</h6>
                                    <a href="{{ route('game', [$comment->commentable->slug]) }}" class="stretched-link" target="_blank"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-inline-block ms-2">
                        <h4 class="game-subtitle">{{ __('Yorum') }}</h4>
                        <div class="comment-body mt-2 p-2 rounded">
                            {!! $comment->body !!}
                        </div>
                    </div>
                </div>
                @if(!$loop->last) <hr> @endif
            @endforeach
        </div>
    {!! $comments->withQueryString()->links() !!}
</div>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $('#sort_by').on('change', function() {
           if ($('#sort_by').val() == 'created_at_asc') {
              $('#sort_dir').val('asc');
           } else if($('#sort_by').val() == 'created_at') {
              $('#sort_dir').val('desc');
           } else if($('#sort_by').val() == 'likes') {
              $('#sort_dir').val('desc');
           } else if($('#sort_by').val() == 'dislikes') {
              $('#sort_dir').val('desc');
           }
           $('#sort_form').submit();
        });
    </script>
@endsection