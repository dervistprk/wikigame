@extends('layouts.backend')
@section('title', 'Makale Ekle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" novalidate method="post" action="{{route('admin.create-article-post')}}" enctype="multipart/form-data">
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
                    <i class="fas fa-book-open"></i>
                    Makale Ekle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title" class="text-primary form-label font-weight-bold">Başlık*</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Makale Başlığını Giriniz" value="{{ old('title') }}" required>
                            <div class="invalid-feedback">
                                Lütfen makale başlığı girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sub_title" class="text-primary form-label font-weight-bold">Alt Başlık*</label>
                            <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Makale Alt Başlığını Giriniz" value="{{ old('sub_title') }}" required>
                            <div class="invalid-feedback">
                                Lütfen makale altbaşlığı girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="writing" class="text-primary form-label font-weight-bold">Makale İçeriği*</label>
                            <textarea class="form-control" id="writing" name="writing" rows="5" placeholder="Makale İçeriğini Giriniz" required>{{ old('writing') }}</textarea>
                            <div class="invalid-feedback">
                                Lütfen makale içeriğini girin.
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="0">Pasif</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen makale durumunu seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="image" class="text-primary col-form-label font-weight-bold">Resim*</label>
                                    <input type="file" name="image" id="image" class="form-control-file btn btn-primary btn-sm" required>
                                    <div class="invalid-feedback">
                                        Lütfen makale resmini seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success "><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.articles')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection
