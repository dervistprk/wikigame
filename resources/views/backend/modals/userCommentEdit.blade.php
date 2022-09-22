<div class="modal fade user-ban-modal" id="user-comment-edit-modal-{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="user-comment-edit-modal-{{ $comment->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-comment-edit-modal-{{ $comment->id }}">Yorum Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.edit-user-comment', $comment->id) }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email" class="col-form-label font-weight-bold">E-Posta</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly style="cursor: not-allowed"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="user_name" class="col-form-label font-weight-bold">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $user->user_name }}" readonly style="cursor: not-allowed"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label font-weight-bold">Ad</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" readonly style="cursor: not-allowed"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="user_name" class="col-form-label font-weight-bold">Soyad</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $user->surname }}" readonly style="cursor: not-allowed"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment_body" class="col-form-label font-weight-bold">Yorum Düzenle</label>
                        <textarea class="form-control" id="comment_body" name="comment_body" placeholder="Yorumu Düzenleyin" required>{!! $comment->body !!}</textarea>
                        <small class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user->id }}"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Düzenle</button>
                </div>
            </form>
        </div>
    </div>
</div>