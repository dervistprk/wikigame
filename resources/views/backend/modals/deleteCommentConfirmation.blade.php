<div class="modal fade" id="delete-comment-{{ $comment->id }}-modal" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="delete-comment-{{ $comment->id }}-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-comment-{{ $comment->id }}-modal">Yorum Sil</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Alttaki yorumu silmek istediğinizden emin misiniz?</h6>
                <div class="alert alert-secondary">
                    {!! $comment->body !!}
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-warning comment-delete-waiting" style="display: none">
                            Yorum siliniyor. Lütfen bekleyin. <i class="fas fa-spin fa-spinner"></i>
                        </div>
                        <div class="alert alert-success comment-delete-success" style="display: none">
                            Yorum başarıyla silindi. Lütfen bekleyin. <i class="fas fa-spin fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-danger delete-comment" data-id="{{ $comment->id }}"><i
                            class="fas fa-trash"></i> Sil
                </button>
            </div>
        </div>
    </div>
</div>