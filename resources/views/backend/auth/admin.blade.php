@extends('layouts.backend')
@section('title', 'Admin Profili')
@section('content')
    <form method="post" action="{{route('admin.profile.post')}}">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif
            @csrf
            <div class="card">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-user"></i>
                    Yönetici Bilgileri
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="email" class="text-info font-weight-bold">E-Posta (*)</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{$admin->email}}" readonly style="cursor: not-allowed">
                    </div>
                    <div class="form-group">
                        <label for="current_password" class="text-info font-weight-bold">Mevcut Şifre (*)</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Mevcut Şifrenizi Girin" required>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="password" class="text-info font-weight-bold">Yeni Şifre (*)</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Şifre Girin" autocomplete="new-password" required/>
                            <span class="small text-secondary"> Şifreniz :
                            <ul>
                                <li>En az bir büyük karakter barındırmaldıır.</li>
                                <li>En az bir küçük karakter barındırmaldıır.</li>
                                <li>En az bir numerik karakter barındırmaldıır.</li>
                                <li>En az altı karakter uzunluğunda olmalıdır.</li>
                            </ul>
                        </span>
                        </div>
                        <div class="col">
                            <label for="password_confirmation" class="text-info font-weight-bold">Yeni Şifre Tekrarı (*)</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Şifre Tekrarını Girin" required/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group m-2 text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.dashboard')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
        </div>
    </form>
@endsection
