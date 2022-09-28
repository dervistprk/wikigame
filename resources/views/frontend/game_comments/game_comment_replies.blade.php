<div class="d-flex flex-start ms-5">
    <img class="rounded-circle shadow-1-strong mt-4 me-3" src="{{ asset('assets/user-no-avatar.png') }}" alt="avatar" width="60" height="60"/>
    <div class="mt-4">
        @php
            $reply_user = \App\Models\User::find($reply->user_id);
        @endphp
        <h6 class="fw-bold mb-1 d-inline-block">{{ $reply_user->name . ' ' . $reply_user->surname }} | <i>{{ $reply_user->user_name }}</i></h6>
        @if($reply_user->isAdmin())
            <span class="badge bg-secondary d-inline-block me-2 ms-2">Yönetici</span>
        @endif
        @if(Auth::check())
            @if(Auth::user()->id == $reply_user->id || Auth::user()->isAdmin())
                <a href="#!" class="link-muted comment-action-links edit-comment-button" data-toggle="tooltip" data-bs-placement="top" title="Yorumu Düzenle"><i class="fas fa-pencil-alt ms-2"></i></a>
                <a href="#!" class="link-muted comment-action-links" data-toggle="tooltip" data-bs-placement="top" title="Yorumu Sil"><i class="fas fa-trash-alt ms-2"></i></a>
            @endif
            <a href="#!" class="link-muted comment-action-links" data-toggle="tooltip" data-bs-placement="top" title="Yorumu Beğen"><i class="fas fa-heart ms-2"></i></a>
        @endif
        <div class="d-flex align-items-center mb-3">
            <p class="mb-0" data-toggle="tooltip" data-bs-placement="top" title="{{ Carbon\Carbon::parse($reply->created_at)->format('d/m/Y H:i:s') }}">
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
                        <textarea class="form-control comment-text" name="edit_comment" id="edit-comment" minlength="30" required>{!! $reply->body !!}</textarea>
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
                <form method="post" action="{{ route('user-reply-game-comment', [$game->id, $reply->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="reply-comment" class="form-label fw-bold">Cevap Yaz</label>
                        <textarea class="form-control comment-text" name="reply_comment" id="reply-comment" minlength="30" required></textarea>
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