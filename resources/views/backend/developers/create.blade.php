@extends('layouts.backend')
@section('title', 'Geliştirici Ekle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" novalidate method="post" action="{{route('admin.create-developer-post')}}" enctype="multipart/form-data">
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
                    <i class="fas fa-calculator"></i>
                    Geliştirici Ekle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Adı*</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Geliştirici Adını Giriniz" value="{{ old('name') }}" required>
                            <div class="invalid-feedback">
                                Lütfen geliştirici adı girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text-primary form-label font-weight-bold">Geliştirici Açıklaması*</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Geliştirici Açıklaması Giriniz" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="0">Pasif</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen durum seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="image" class="text-primary col-form-label font-weight-bold">Resim*</label>
                                    <input type="file" name="image" id="image" class="form-control-file btn btn-primary btn-sm" required>
                                    <div class="invalid-feedback">
                                        Lütfen geliştirici resmi seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.developers')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection