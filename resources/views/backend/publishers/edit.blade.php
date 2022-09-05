@extends('layouts.backend')
@section('title', 'Dağıtıcı Düzenle')
@section('content')
    <div class="container">
        <form class="container mt-2" method="post" action="{{route('admin.edit-publisher-post', [$publisher->id])}}" enctype="multipart/form-data">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger text-center alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @csrf
            <div class="card shadow">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-newspaper"></i>
                    Dağıtıcı Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Adı*</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Dağıtıcı Adını Giriniz" value="{{ $publisher->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text-primary form-label font-weight-bold">Dağıtıcı Açıklaması*</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Dağıtıcı Açıklaması Giriniz" required>{{ $publisher->description }}</textarea>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status">
                                        <option @if($publisher->status == 0) selected="selected" @endif value="0">Pasif</option>
                                        <option @if($publisher->status == 1) selected="selected" @endif value="1">Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="image" class="text-primary col-form-label font-weight-bold">Resim</label>
                                    <input type="file" name="image" id="image" class="form-control-file btn btn-primary btn-sm">
                                    @if(isset($publisher->image))
                                        <img src="{{ $publisher->image }}" alt="{{ $publisher->name }}" title="{{ $publisher->name }}" class="mt-1 img-fluid img-thumbnail rounded" width="175" height="130">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.publishers')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
            @include('backend.modals.statusDialog')
        </form>
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $('#status').change(function() {
          var publisher_status      = {{ $publisher->status }};
          var publisher_games_count = {{ $publisher->games->count() }};

          if (publisher_status == 1 && publisher_games_count > 0 && $(this).val() == 0) {
             $('#dialog-confirm').removeClass('d-none');
             $('#dialog-confirm').dialog({
                resizable  : false,
                dialogClass: 'no-close',
                height     : 'auto',
                width      : 'auto',
                draggable  : false,
                modal      : true,
                show       : true,
                hide       : true,
                buttons    : [
                   {
                      text   : 'Tamam',
                      'class': 'btn btn-sm btn-primary',
                      click  : function() {
                         $(this).dialog('close');
                      }
                   }
                ]
             });
          }
       });
    </script>
@endsection
