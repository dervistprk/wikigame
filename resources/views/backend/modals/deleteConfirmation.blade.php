<div class="modal fade" id="delete{{$target->slug}}Modal_{{$target->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="delete{{$target->slug}}ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete{{$target->slug}}ModalLabel">Silme Onay Penceresi</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.delete-' . $route, $target->id) }}">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <h6 class="text-center"><strong>{{ $target->name ?? $target->title }}</strong> ögesini silmek istediğinizden emin misiniz?</h6>
                    @if(isset($target->cover_image))
                        <img src="{{ $target->cover_image }}" alt="{{ $target->name }} Kapak Resmi" title="{{ $target->name }} Kapak Resmi" class="img-fluid img-thumbnail" width="150" height="200">
                    @elseif(isset($target->image))
                        <img src="{{ $target->image }}" alt="{{ $target->name ?? $target->title }}" title="{{ $target->name ?? $target->title }} Kapak Resmi" class="img-fluid img-thumbnail" width="200" height="150">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Sil</button>
                </div>
            </form>
        </div>
    </div>
</div>