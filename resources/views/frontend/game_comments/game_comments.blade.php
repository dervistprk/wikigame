<div class="d-flex flex-start parent-comment-layout">
    <img class="rounded-circle shadow-1-strong mt-4 me-3" src="{{ asset('assets/user-no-avatar.png') }}" alt="avatar"
         width="60" height="60"/>
    <div class="mt-4">
        @php
            $user = \App\Models\User::find($comment->user_id);
            $disabled_like_button    = false;
            $disabled_dislike_button = false;
            foreach ($comment->likedUsers as $like) {
                if ($like->user == Auth::user()) {
                    $disabled_like_button = true;
                }
            }
            foreach ($comment->dislikedUsers as $dislike) {
                if ($dislike->user == Auth::user()) {
                    $disabled_dislike_button = true;
                }
            }
        @endphp
        <h6 class="fw-bold mb-1 d-inline-block">{{ $user->name . ' ' . $user->surname }} | <i>{{ $user->user_name }}</i>
        </h6>
        @if($user->isAdmin())
            <span class="badge bg-secondary d-inline-block me-2 ms-2">Yönetici</span>
        @endif
        @if(Auth::check())
            @if(Auth::user()->id == $user->id || Auth::user()->isAdmin())
                <a href="#!" class="link-muted comment-action-links edit-comment-button" data-toggle="tooltip"
                   data-bs-placement="top" title="Yorumu Düzenle"><i class="fas fa-pencil-alt ms-2"></i></a>
                <a href="#!" class="link-muted comment-action-links delete-comment-button" data-id="{{ $comment->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Sil"><i
                        class="fas fa-trash-alt ms-2"></i></a>
            @endif
            @if(Auth::user()->id != $user->id)
                <a href="#!" class="link-muted comment-action-links reply-comment-button" data-toggle="tooltip"
                   data-bs-placement="top" title="Yanıtla"><i class="fas fa-reply ms-2"></i></a>
                <a href="#!" class="link-muted comment-action-links like-comment-button" data-id="{{ $comment->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen"
                   @if($disabled_like_button) style="pointer-events: none" @endif><i class="fas fa-thumbs-up ms-2"></i></a>
                @if($comment->likes > 0)
                    <span class="badge bg-primary rounded-pill like-count">{{ $comment->likes }}</span>
                @endif
                <a href="#!" class="link-muted comment-action-links dislike-comment-button" data-id="{{ $comment->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğenme"
                   @if($disabled_dislike_button) style="pointer-events: none" @endif><i
                        class="fas fa-thumbs-down ms-2"></i></a>
                @if($comment->dislikes > 0)
                    <span class="badge bg-danger rounded-pill dislike-count">{{ $comment->dislikes }}</span>
                @endif
            @else
                <a href="#!" class="link-muted comment-action-links like-comment-button" data-id="{{ $comment->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen" style="pointer-events: none"><i
                        class="fas fa-thumbs-up ms-2"></i></a>
                @if($comment->likes > 0)
                    <span class="badge bg-primary rounded-pill like-count">{{ $comment->likes }}</span>
                @endif
                <a href="#!" class="link-muted comment-action-links dislike-comment-button" data-id="{{ $comment->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğenme" style="pointer-events: none"><i
                        class="fas fa-thumbs-down ms-2"></i></a>
                @if($comment->dislikes > 0)
                    <span class="badge bg-danger rounded-pill dislike-count">{{ $comment->dislikes }}</span>
                @endif
            @endif
        @else
            <a href="#!" class="link-muted comment-action-links like-comment-button" data-id="{{ $comment->id }}"
               data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen" style="pointer-events: none"><i
                    class="fas fa-thumbs-up ms-2"></i></a>
            @if($comment->likes > 0)
                <span class="badge bg-primary rounded-pill like-count">{{ $comment->likes }}</span>
            @endif
            <a href="#!" class="link-muted comment-action-links dislike-comment-button" data-id="{{ $comment->id }}"
               data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğenme" style="pointer-events: none"><i
                    class="fas fa-thumbs-down ms-2"></i></a>
            @if($comment->dislikes > 0)
                <span class="badge bg-danger rounded-pill dislike-count">{{ $comment->dislikes }}</span>
            @endif
        @endif
        <div class="d-flex align-items-center mb-3">
            <p class="mb-0" data-toggle="tooltip" data-bs-placement="top"
               title="{{ Carbon\Carbon::parse($comment->created_at)->format('d/m/Y H:i:s') }}">
                {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
            </p>
        </div>
        <div class="edit-form" style="display: none;">
            <div class="col-sm-10 col-md-10 col-lg-10 mt-2">
                <button class="btn btn-sm btn-danger float-end mb-3 close-edit-form-button">
                    <i class="fas fa-times-circle"></i>
                </button>
                <form method="post" action="{{ route('user-edit-game-comment', [$game->id, $comment->id]) }}">
                    @csrf
                    <div class="mb-3 edit-text-layout">
                        <label for="edit-comment" class="form-label fw-bold">Yorum Düzenle</label>
                        <textarea class="form-control comment-text edit-comment-text" name="edit_comment"
                                  id="edit-comment" minlength="30" required>{!! $comment->body !!}</textarea>
                    </div>
                    <div class="mb-3 edit-comment-layout">
                        <button type="submit" class="btn btn-sm btn-primary float-end submit-edit">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="comment-body rounded p-3">
            {!! $comment->body !!}
        </div>
        @if($comment->replies->count() > 0)
            @if($comment->replies->count() > 1)
                @php
                    $replies_to_paginate = $comment->replies()->paginate(1, ['*'], 'cevaplar');
                @endphp
                <div class="comment-replies-layout">
                    @foreach($replies_to_paginate as $reply)
                        @include('frontend.game_comments.game_comment_replies')
                    @endforeach
                </div>
                {!! $replies_to_paginate->links() !!}
                <div class="d-flex justify-content-center align-items-center">
                    <button class="btn btn-secondary m-2 see-more-reply" type="button" data-page="2"
                            data-id="{{ $comment->id }}">Daha Fazla
                    </button>
                </div>
            @else
                @foreach($comment->replies as $reply)
                    @include('frontend.game_comments.game_comment_replies')
                @endforeach
            @endif
        @endif
        <div class="reply-form" style="display: none;">
            <div class="col-sm-10 col-md-10 col-lg-10 mt-2">
                <button class="btn btn-sm btn-danger float-end mb-3 close-reply-form-button">
                    <i class="fas fa-times-circle"></i>
                </button>
                <form method="post" action="{{ route('user-reply-game-comment', [$game->id, $comment->id]) }}">
                    @csrf
                    <div class="mb-3 reply-text-layout">
                        <label for="reply-comment" class="form-label fw-bold">Cevap Yaz</label>
                        <textarea class="form-control comment-text reply-comment-text" name="reply_comment"
                                  id="reply-comment" minlength="30" required></textarea>
                    </div>
                    <div class="mb-3 reply-comment-layout">
                        <button type="submit" class="btn btn-sm btn-primary float-end submit-reply">Yanıtla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
