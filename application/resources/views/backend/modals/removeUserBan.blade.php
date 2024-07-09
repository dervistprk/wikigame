<div class="modal fade" id="remove-user-ban-modal-{{ $user->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yasak Kaldır</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>
                    <strong class="text-primary">{{ $user->name }} {{ $user->surname }}</strong> isimli kullanıcının yasağını kaldırmak istiyor musunuz?
                </h6>
                <div class="alert alert-info">
                    <h6>Yasaklanma Sebebi</h6>
                    {!! $user->ban_reason !!}
                </div>
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col">
                            <h6>Yasaklayan Yönetici</h6>
                            {{ $user->banned_by }}
                        </div>
                        <div class="col">
                            <h6>Yasaklanma Tarihi</h6>
                            {{ \Carbon\Carbon::parse($user->banned_at)->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
                <div class="alert alert-success user-ban-remove-message d-none">
                    Kullanıcı yasağı başarı ile kaldırıldı. Lütfen bekleyin. <i class="fas fa-spinner fa-spin"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-id="{{ $user->id }}" class="btn btn-success remove-ban">Yasak Kaldır</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>