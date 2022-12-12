@extends('layouts.backend')
@section('title', 'Kullanıcı Düzenle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" novalidate method="post" action="{{ route('admin.edit-whitelist-user-post', [$whitelist_user->id]) }}">
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
                    <i class="fas fa-user"></i>
                    Kullanıcı Düzenle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ip" class="text-primary form-label font-weight-bold">IP Adresi*</label>
                            <input type="text" class="form-control" id="ip" name="ip"
                                   placeholder="IP Adresi Giriniz" value="{{ $whitelist_user->ip }}" required>
                            <div class="invalid-feedback">
                                Lütfen IP adresi girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Ad Soyad*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Ad Soyad Giriniz" value="{{ $whitelist_user->name }}" required>
                            <div class="invalid-feedback">
                                Lütfen ad soyad girin.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{ route('admin.whitelist-users') }}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection