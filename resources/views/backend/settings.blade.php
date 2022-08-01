@extends('layouts.backend')
@section('title', 'Site Ayarları')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.settings-update')}}" enctype="multipart/form-data">
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
                <i class="fas fa-cog"></i>
                Site Ayarları <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="footer_text" class="font-weight-bold text-primary">Site Footer Yazısı</label>
                    <input type="text" class="form-control" id="footer_text" name="footer_text" placeholder="Site Footer İçeriğini Giriniz" value="{{ $settings->footer_text }}">
                </div>
                <div class="form-group">
                    <label for="about_text" class="font-weight-bold text-primary">Site Hakkında Yazısı*</label>
                    <textarea class="form-control" id="about_text" name="about_text" rows="5" placeholder="Site Hakkında İçeriğini Giriniz">{{ $settings->about_text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="meta_description" class="font-weight-bold text-primary">Meta Açıklaması*</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Meta Açıklaması Giriniz" value="{{ $settings->meta_description }}" required>
                </div>
                <div class="form-row">
                    <div class="col ">
                        <label for="facebook" class="font-weight-bold text-primary">Facebook Adresi</label>
                        <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook Adresi Giriniz" value="{{ $settings->facebook }}">
                    </div>
                    <div class="col ">
                        <label for="twitter" class="font-weight-bold text-primary">Twitter Adresi</label>
                        <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter Adresi Giriniz" value="{{ $settings->twitter }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mt-2">
                        <label for="github" class="font-weight-bold text-primary">Github Adresi</label>
                        <input type="text" class="form-control" id="github" name="github" placeholder="Github Adresi Giriniz" value="{{ $settings->github }}">
                    </div>
                    <div class="col mt-2">
                        <label for="linkedin" class="font-weight-bold text-primary">Linkedin Adresi</label>
                        <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="Linkedin Adresi Giriniz" value="{{ $settings->linkedin }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mt-2">
                        <label for="youtube" class="font-weight-bold text-primary">Youtube Adresi</label>
                        <input type="text" class="form-control" id="youtube" name="youtube" placeholder="Youtube Adresi Giriniz" value="{{ $settings->youtube }}">
                    </div>
                    <div class="col mt-2">
                        <label for="instagram" class="font-weight-bold text-primary">Instagram Adresi</label>
                        <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Instagram Adresi Giriniz" value="{{ $settings->instagram }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mt-2">
                        <label for="favicon" class="font-weight-bold text-primary">Site Favicon</label>
                        @if(isset($settings->favicon))
                            <img src="{{ $settings->favicon }}" alt="Site Favicon" title="Site Favicon" width="25" height="25">
                        @endif
                        <input type="file" name="favicon" id="favicon" class="form-control btn btn-primary btn-sm">
                    </div>
                    <div class="col mt-2">
                        <label for="logo" class="font-weight-bold text-primary">Site Logo</label>
                        @if(isset($settings->logo))
                            <img src="{{ $settings->logo }}" alt="Site Logo" title="Site Logo" class="mb-2" width="25" height="25">
                        @endif
                        <input type="file" name="logo" id="logo" class="form-control btn btn-primary btn-sm">
                    </div>
                    <div class="col mt-2">
                        <label for="backend_favicon" class="font-weight-bold text-primary">Backend Favicon</label>
                        @if(isset($settings->backend_favicon))
                            <img src="{{ $settings->backend_favicon }}" alt="Backend Favicon" title="Backend Favicon" width="25" height="25">
                        @endif
                        <input type="file" name="backend_favicon" id="backend_favicon" class="form-control btn btn-primary btn-sm">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="site_status" class="font-weight-bold text-primary">Site Durumu*</label>
                    <select class="form-control custom-select" id="site_status" name="site_status">
                        <option value="0" @if($settings->site_status == 0) selected="selected"@endif>Pasif</option>
                        <option value="1" @if($settings->site_status == 1) selected="selected"@endif>Aktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Kaydet</button>
            <a href="{{route('admin.publishers')}}" class="btn btn-danger btn-block">Vazgeç</a>
        </div>
    </form>
@endsection
