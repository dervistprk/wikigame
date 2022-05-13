@extends('layouts.backend')
@section('title', 'Makale Ekle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.create-article-post')}}" enctype="multipart/form-data">
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
                <i class="fas fa-book-open"></i>
                Makale Ekle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="text-primary font-weight-bold">Başlık*</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Makale Başlığını Giriniz" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label for="sub_title" class="text-primary font-weight-bold">AltBaşlık*</label>
                    <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Makale Altbaşlığını Giriniz" value="{{ old('sub_title') }}" required>
                </div>
                <div class="form-group">
                    <label for="writing" class="text-primary font-weight-bold">Makale İçeriği*</label>
                    <textarea class="form-control" id="writing" name="writing" rows="5" placeholder="Makale İçeriğini Giriniz" required>{{ old('writing') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status" class="text-primary font-weight-bold">Durum*</label>
                    <select class="form-control" id="status" name="status">
                        <option value="0">Pasif</option>
                        <option value="1">Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image" class="text-primary font-weight-bold">Resim*</label>
                    <input type="file" name="image" id="image" class="form-control btn btn-primary btn-sm" required>
                </div>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
            <button type="submit" class="btn btn-success "><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.articles')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
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
            $('#writing').summernote({
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

