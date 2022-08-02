@extends('layouts.backend')
@section('title', 'Makale Düzenle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.edit-article-post', [$article->id])}}" enctype="multipart/form-data">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @csrf
        <div class="card">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-book-open"></i>
                Makale Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="text-primary font-weight-bold">Başlık*</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Makale Başlığını Giriniz" value="{{ $article->title }}" required>
                </div>
                <div class="form-group">
                    <label for="writing" class="text-primary font-weight-bold">Makale İçeriği*</label>
                    <textarea class="form-control" id="writing" name="writing" rows="5" placeholder="Makale İçeriğini Giriniz" required>{{ $article->writing }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status" class="text-primary font-weight-bold">Durum*</label>
                    <select class="form-control custom-select" id="status" name="status">
                        <option @if($article->status == 0) selected="selected" @endif value="0">Pasif</option>
                        <option @if($article->status == 1) selected="selected" @endif value="1">Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image" class="text-primary font-weight-bold">Resim</label>
                    <input type="file" name="image" id="image" class="form-control btn btn-primary btn-sm">
                    @if(isset($article->image))
                        <img src="{{ $article->image }}" alt="{{ $article->title }}" title="{{ $article->title }}" class="mt-1 rounded" width="640" height="480">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.articles')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
        </div>
    </form>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-tr-TR.js"></script>
    <script>
        $(document).ready(function () {
            $('#writing').summernote({
                toolbar: [
                    ['style'],
                    ['fontsize'],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontname'],
                    ['color'],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'hr', 'video']],
                    ['table', ['table']],
                    ['codeview', ['codeview']],
                    ['link', ['link']],
                    ['actions', ['undo', 'redo']],
                ],
                fontSizes: ['7', '8', '9', '10', '11', '12', '14','16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36', '48'],
                height: 400,
                focus: false,
                placeholder: 'Makale İçeriğini Giriniz',
                dialogsFade: true,
                lang: 'tr-TR'
                }
            );
        });
    </script>
@endsection

