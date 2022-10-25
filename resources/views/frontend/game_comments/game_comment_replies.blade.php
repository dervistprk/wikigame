<div class="subcomment-layout">
    <div class="d-flex flex-start ms-5">
        <img class="rounded-circle shadow-1-strong mt-4 me-3" src="{{ asset('assets/user-no-avatar.png') }}"
             alt="avatar" width="60" height="60"/>
        <div class="mt-4">
            @php
                $reply_user = \App\Models\User::find($reply->user_id);
                $disabled_like_button_reply    = false;
                $disabled_dislike_button_reply = false;
                foreach ($reply->likedUsers as $like) {
                    if ($like->user == Auth::user()) {
                        $disabled_like_button_reply = true;
                    }
                }
                foreach ($reply->dislikedUsers as $dislike) {
                    if ($dislike->user == Auth::user()) {
                        $disabled_dislike_button_reply = true;
                    }
                }
            @endphp
            <h6 class="fw-bold mb-1 d-inline-block">{{ $reply_user->name . ' ' . $reply_user->surname }} |
                <i>{{ $reply_user->user_name }}</i></h6>
            @if($reply_user->isAdmin())
                <span class="badge bg-secondary d-inline-block me-2 ms-2">Yönetici</span>
            @endif
            @if(Auth::check())
                @if(Auth::user()->id == $reply_user->id || Auth::user()->isAdmin())
                    <a href="#!" class="link-muted comment-action-links edit-comment-button" data-toggle="tooltip"
                       data-bs-placement="top" title="Yorumu Düzenle"><i class="fas fa-pencil-alt ms-2"></i></a>
                    <a href="#!" class="link-muted comment-action-links delete-comment-button"
                       data-id="{{ $reply->id }}" data-toggle="tooltip" data-bs-placement="top" title="Yorumu Sil"><i
                                class="fas fa-trash-alt ms-2"></i></a>
                @endif
                @if(Auth::user()->id != $reply_user->id)
                    <a href="#!" class="link-muted comment-action-links reply-comment-button" data-toggle="tooltip"
                       data-bs-placement="top" title="Yanıtla"><i class="fas fa-reply ms-2"></i></a>
                    <a href="#!" class="link-muted comment-action-links like-comment-button" data-id="{{ $reply->id }}"
                       data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen"
                       @if($disabled_like_button_reply) style="pointer-events: none" @endif><i
                                class="fas fa-thumbs-up ms-2"></i></a>
                    @if($reply->likes > 0)
                        <span class="badge bg-primary rounded-pill like-count">{{ $reply->likes }}</span>
                    @endif
                    <a href="#!" class="link-muted comment-action-links dislike-comment-button"
                       data-id="{{ $reply->id }}" data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğenme"
                       @if($disabled_dislike_button_reply) style="pointer-events: none" @endif><i
                                class="fas fa-thumbs-down ms-2"></i></a>
                    @if($reply->dislikes > 0)
                        <span class="badge bg-danger rounded-pill dislike-count">{{ $reply->dislikes }}</span>
                    @endif
                @else
                    <a href="#!" class="link-muted comment-action-links like-comment-button" data-id="{{ $reply->id }}"
                       data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen"
                       style="pointer-events: none"><i class="fas fa-thumbs-up ms-2"></i></a>
                    @if($reply->likes > 0)
                        <span class="badge bg-primary rounded-pill like-count">{{ $reply->likes }}</span>
                    @endif
                    <a href="#!" class="link-muted comment-action-links dislike-comment-button"
                       data-id="{{ $reply->id }}" data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğenme"
                       style="pointer-events: none"><i class="fas fa-thumbs-down ms-2"></i></a>
                    @if($reply->dislikes > 0)
                        <span class="badge bg-danger rounded-pill dislike-count">{{ $reply->dislikes }}</span>
                    @endif
                @endif
            @else
                <a href="#!" class="link-muted comment-action-links like-comment-button" data-id="{{ $reply->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen" style="pointer-events: none"><i
                            class="fas fa-thumbs-up ms-2"></i></a>
                @if($reply->likes > 0)
                    <span class="badge bg-primary rounded-pill like-count">{{ $reply->likes }}</span>
                @endif
                <a href="#!" class="link-muted comment-action-links dislike-comment-button" data-id="{{ $reply->id }}"
                   data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğenme" style="pointer-events: none"><i
                            class="fas fa-thumbs-down ms-2"></i></a>
                @if($reply->dislikes > 0)
                    <span class="badge bg-danger rounded-pill dislike-count">{{ $reply->dislikes }}</span>
                @endif
            @endif
            <div class="d-flex align-items-center mb-3">
                <p class="mb-0" data-toggle="tooltip" data-bs-placement="top"
                   title="{{ Carbon\Carbon::parse($reply->created_at)->format('d/m/Y H:i:s') }}">
                    {{ Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}
                </p>
            </div>
            <div class="edit-form" style="display: none;">
                <div class="col-sm-10 col-md-10 col-lg-10 mt-2">
                    <button class="btn btn-sm btn-danger float-end mb-3 close-edit-form-button">
                        <i class="fas fa-times-circle"></i>
                    </button>
                    <form method="post" action="{{ route('user-edit-game-comment', [$game->id, $reply->id]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="edit-comment" class="form-label fw-bold">Yorum Düzenle</label>
                            <textarea class="form-control comment-text" name="edit_comment" id="edit-comment"
                                      minlength="30" required>{!! $reply->body !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary float-end">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="comment-body rounded p-3">
                {!! $reply->body !!}
            </div>
            <div class="reply-form" style="display: none;">
                <div class="col-sm-10 col-md-10 col-lg-10 mt-2">
                    <button class="btn btn-sm btn-danger float-end mb-3 close-reply-form-button">
                        <i class="fas fa-times-circle"></i>
                    </button>
                    <form method="post"
                          action="{{ route('user-reply-game-comment', [$game->id, $comment->id, $reply->id]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="reply-comment" class="form-label fw-bold">Cevap Yaz</label>
                            <textarea class="form-control comment-text" name="reply_comment" id="reply-comment"
                                      minlength="30" required></textarea>
                        </div>
                        <input type="hidden" name="comment_id" value="{{ $reply->id }}"/>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary float-end">Yanıtla</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
