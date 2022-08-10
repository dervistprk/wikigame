@extends('layouts.backend')
@section('title', 'Kategori Düzenle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" method="post" novalidate action="{{route('admin.edit-category-post', [$category->id])}}">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="alert alert-danger text-center alert-dismissible fade show">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endif
            @csrf
            <div class="card shadow">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-bookmark"></i>
                    Kategori Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Adı*</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Kategori Adını Giriniz" value="{{ $category->name }}" required>
                            <div class="invalid-feedback">
                                Lütfen kategori adı girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text-primary form-label font-weight-bold">Kategori Açıklaması*</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Kategori Açıklaması Giriniz" required>{{ $category->description }}</textarea>
                            <div class="invalid-feedback">
                                Lütfen kategori açıklaması girin.
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status">
                                        <option @if($category->status == 0) selected="selected" @endif value="0">Pasif</option>
                                        <option @if($category->status == 1) selected="selected" @endif value="1">Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.categories')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection