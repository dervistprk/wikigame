@extends('layouts.backend')
@section('title', 'Dağıtıcı Düzenle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.edit-publisher-post', [$publisher->id])}}" enctype="multipart/form-data">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif
        @csrf
        <div class="card">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-newspaper"></i>
                Dağıtıcı Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="text-primary font-weight-bold">Adı*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Dağıtıcı Adını Giriniz" value="{{ $publisher->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description" class="text-primary font-weight-bold">Dağıtıcı Açıklaması*</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Dağıtıcı Açıklaması Giriniz" required>{{ $publisher->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status" class="text-primary font-weight-bold">Durum*</label>
                    <select class="form-control" id="status" name="status">
                        <option @if($publisher->status == 0) selected="selected" @endif value="0">Pasif</option>
                        <option @if($publisher->status == 1) selected="selected" @endif value="1">Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image" class="text-primary font-weight-bold">Resim</label>
                    <input type="file" name="image" id="image" class="form-control btn btn-primary btn-sm">
                    @if(isset($publisher->image))
                        <img src="{{ $publisher->image }}" alt="{{ $publisher->name }}" title="{{ $publisher->name }}" class="mt-1 rounded" width="125" height="100">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.publishers')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
        </div>
    </form>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                    toolbar: [
                        ['style', ['style']],
                        ['fontsize', ['fontsize']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['picture', 'hr']],
                        ['table', ['table']]
                    ],
                    fontSizes: ['8', '9', '10', '11', '12', '14','16', '18', '20', '22', '24', '36', '48', '64', '82', '150'],
                    height: 400,
                    focus: false
                }
            );
        });
    </script>
@endsection

