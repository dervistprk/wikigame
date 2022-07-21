@extends('layouts.backend')
@section('title', 'Kategori Düzenle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.edit-category-post', [$category->id])}}">
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
                <i class="fas fa-bookmark"></i>
                Kategori Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="text-primary font-weight-bold">Adı*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Kategori Adını Giriniz" value="{{ $category->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description" class="text-primary font-weight-bold">Kategori Açıklaması*</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Kategori Açıklaması Giriniz" required>{{ $category->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status" class="text-primary font-weight-bold">Durum*</label>
                    <select class="form-control" id="status" name="status">
                        <option @if($category->status == 0) selected="selected" @endif value="0">Pasif</option>
                        <option @if($category->status == 1) selected="selected" @endif value="1">Aktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.categories')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
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
            $('#description').summernote({
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
                placeholder: 'Kategori Açıklaması Giriniz',
                dialogsFade: true,
                lang: 'tr-TR'
                }
            );
        });
    </script>
@endsection

