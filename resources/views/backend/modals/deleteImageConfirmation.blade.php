<div class="modal fade" id="delete-image-{{ $image_count + 1 }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Resim Silme Onay Penceresi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bu resmi silmek istediğinizden emin misiniz?
                <img src="{{ $image->path }}" alt="{{ $game->name }} Resim{{ $image_count + 1 }}"
                     title="{{ $game->name }} Resim{{ $image_count + 1 }}" class="mt-1 rounded img-fluid img-thumbnail"
                     width="500" height="300">
                <div class="alert alert-success image-delete-response d-none">
                    Resim başarıyla silindi. Lütfen bekleyin. <i class="fas fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-danger delete-image-btn"><i class="fa fa-trash-alt"></i> Sil
                </button>
                <input type="hidden" id="image-hash-modal" value="{{ $image->image_hash }}"/>
            </div>
        </div>
    </div>
</div>