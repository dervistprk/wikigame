@extends('layouts.backend')
@section('title', 'Platform Ekle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" novalidate method="post" action="{{route('admin.create-platform-post')}}">
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
                    <i class="fas fa-laptop"></i>
                    Platform Ekle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Adı*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Platform Adını Giriniz" value="{{ old('name') }}" required>
                            <div class="invalid-feedback">
                                Lütfen platform adı girin.
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status"
                                           class="text-primary col-form-label col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="" hidden>Durum Seçiniz</option>
                                        @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}"
                                                    @if(old('status') == $key) selected="selected" @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen platform durumu seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.platforms')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection