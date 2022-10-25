@extends('layouts.backend')
@section('title', 'Admin Profili')
@section('content')
    <div class="container">
        <form method="post" class="mt-2 needs-validation" novalidate action="{{route('admin.profile-post')}}">
            @if(session()->has('message'))
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-warning m-2 alert-dismissible fade show text-center">
                            {!! session()->get('message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
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
                    Yönetici Bilgileri
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="email" class="text-primary font-weight-bold">E-Posta *</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{$admin->email}}"
                                   readonly style="cursor: not-allowed">
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="current_password"
                                           class="text-primary font-weight-bold">Mevcut Şifre *</label>
                                    <input type="password" name="current_password" id="current_password"
                                           class="form-control" placeholder="Mevcut Şifrenizi Girin" required/>
                                    <div class="invalid-feedback">
                                        Lütfen mevcut şifrenizi girin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="password" class="text-primary font-weight-bold">Yeni Şifre *</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="Şifre Girin" autocomplete="new-password" required/>
                                    <div class="invalid-feedback">
                                        Lütfen yeni şifrenizi girin.
                                    </div>
                                    <span class="small text-secondary"> Şifreniz :
                                        <ul>
                                            <li>En az bir büyük karakter barındırmaldıır.</li>
                                            <li>En az bir küçük karakter barındırmaldıır.</li>
                                            <li>En az bir numerik karakter barındırmaldıır.</li>
                                            <li>En az altı karakter uzunluğunda olmalıdır.</li>
                                        </ul>
                                    </span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="password_confirmation"
                                           class="text-primary font-weight-bold">Yeni Şifre Tekrarı *</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" autocomplete="new-password"
                                           placeholder="Şifre Tekrarını Girin" required/>
                                    <div class="alert alert-danger d-none mt-2" id="password-confirmation-alert">
                                        Şifre tekrarları eşleşmiyor.
                                    </div>
                                    <div class="invalid-feedback">
                                        Lütfen yeni şifrenizi tekrar girin.
                                    </div>
                                </div>
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
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $('#password, #password_confirmation').on('change', function() {
          if ($('#password_confirmation').val()) {
             if ($('#password').val() != $('#password_confirmation').val()) {
                $('#password-confirmation-alert').removeClass('d-none');
             } else {
                $('#password-confirmation-alert').addClass('d-none');
             }
          }
       });
    </script>
@endsection
