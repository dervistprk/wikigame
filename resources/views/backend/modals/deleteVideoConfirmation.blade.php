<div class="modal fade" id="delete-video-{{ $video_count }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Video Silme Onay Penceresi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bu videoyu silmek istediğinizden emin misiniz?
                <div class="embed-responsive embed-responsive-16by9" id="youtube-video-{{ $video_count }}">
                    <div class="embed-responsive-item">
                        <iframe src="{{ $video->url }}" class="mt-2 rounded" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="alert d-none" id="response-message"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-danger delete-video-btn"><i class="fa fa-trash-alt"></i> Sil</button>
                <input type="hidden" id="video-hash-modal" value="{{ $video->video_hash }}"/>
            </div>
        </div>
    </div>
</div>