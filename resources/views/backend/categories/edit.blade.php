@extends('layouts.backend')
@section('title', 'Kategori Düzenle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.edit-category-post', [$category->id])}}">
        @if($errors->any())
            <div class="alert alert-danger text-center alert-dismissible fade show">
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
                    <select class="form-control custom-select" id="status" name="status">
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