<div class="modal fade" id="delete-multiple-modal" tabindex="-1" role="dialog"
     aria-labelledby="delete-multiple-modal-lable" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-multiple-modal-lable">Silme Onay Penceresi</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>
                    <i class="fas fa-exclamation-triangle text-danger"></i> Seçili {{ $plural }} silmek istediğinize emin misiniz?
                </h6>
                @if(isset($target->games))
                    <div class="alert alert-warning">
                        <h6>Uyarı</h6>
                        <p>Ögelere ait oyunlar mevcut ise oyunlar <strong>pasife</strong> alınacaktır.</p>
                    </div>
                @endif
                <div class="d-none" id="multiple-delete-message">
                    <div class="alert alert-success m-2 alert-dismissible fade show text-center">
                        Seçili ögeler başarıyla silindi. Lütfen bekleyin
                        <i class="fas fa-spinner fa-spin"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-danger" id="multiple-destroy-button"><i
                            class="fas fa-spinner fa-spin d-none" id="delete-loading-icon"></i> Sil
                </button>
            </div>
        </div>
    </div>
</div>