@extends('layouts.app')
@section('title', 'Profil Güncelle')
@section('content')
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <form class="game-info rounded col-sm-10 mt-2" action="{{ route('update-profile') }}" method="post" id="update-profile-form">
            @if($errors->any())
                <div class="alert alert-danger mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            @csrf
            <div class="btn-group h-100 d-flex align-items-center justify-content-center mt-2" role="group">
                <a type="button" class="btn btn-primary btn-lg active" href=" {{route('update-profile')}}" style="pointer-events: none">Profil Bilgilerimi Güncelle</a>
                <a type="button" class="btn btn-danger btn-lg" href="#">Şifremi Güncelle</a>
                <a type="button" class="btn btn-warning btn-lg" href="#">Yorumlarım</a>
            </div>
            <h2 class="dev-header text-center mt-2">Profil Bilgilerimi Güncelle</h2>
            <span class="float-end small form-text text-muted">* Şifrenizi değiştirmek istemiyorsanız boş bırakın.</span>
            <div class="m-4">
                <div class="form-group">
                    <label for="email" class="font-weight-bold">E-Posta</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ $user->email }}" readonly style="cursor: not-allowed"/>
                </div>
                <div class="form-group">
                    <label for="user_name" class="font-weight-bold">Kullanıcı Adı</label>
                    <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Kullanıcı Adı Girin" value="{{ $user->user_name }}" readonly style="cursor: not-allowed"/>
                </div>
                <div class="form-group">
                    <label for="current_password" class="font-weight-bold">Mevcut Şifre (*)</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Mevcut Şifrenizi Girin"/>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="password" class="font-weight-bold">Yeni Şifre (*)</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Şifre Girin" autocomplete="new-password"/>
                        <span class="small form-text text-muted"> Şifreniz :
                            <ul>
                                <li>En az bir büyük karakter barındırmaldıır.</li>
                                <li>En az bir küçük karakter barındırmaldıır.</li>
                                <li>En az bir numerik karakter barındırmaldıır.</li>
                                <li>En az altı karakter uzunluğunda olmalıdır.</li>
                            </ul>
                        </span>
                    </div>
                    <div class="col">
                        <label for="password_confirmation" class="font-weight-bold">Yeni Şifre Tekrarı (*)</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Şifre Tekrarını Girin"/>
                    </div>
                </div>
                <hr>
                <h5 class="dev-header">Kişisel Bilgiler</h5>
                <div class="form-row">
                    <div class="col">
                        <label for="name" class="font-weight-bold">Ad</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required/>
                    </div>
                    <div class="col">
                        <label for="surname" class="font-weight-bold">Soyad</label>
                        <input type="text" name="surname" class="form-control" id="surname" value="{{ $user->surname }}" required/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mt-2">
                        <label for="birth_day" class="font-weight-bold">Doğum Tarihi</label>
                        <input type="date" name="birth_day" class="form-control" id="birth_day" value="{{ date('Y-m-d', strtotime($user->birth_day)) }}" required/>
                    </div>
                    <div class="col mt-2">
                        <label for="gender" class="font-weight-bold">Cinsiyet</label>
                        <select class="form-control custom-select" name="gender" id="gender" required>
                            <option value="">Lütfen Seçiniz</option>
                            <option value="erkek" @if($user->gender == 'erkek') selected @endif>Erkek</option>
                            <option value="kadin" @if($user->gender == 'kadin') selected @endif>Kadın</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="user_about_text" class="font-weight-bold">Hakkımda</label>
                    <textarea class="form-control" name="about" id="user_about_text" rows="7" placeholder="Hakkınızda tanıtıcı kısa bir yazı yazın." onkeyup="countChar(this)" required>{{ $user->about }}</textarea>
                    <small id="emailHelp" class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
                    <span id="charNum" class="text-muted d-inline-block float-end"></span>
                </div>
                <hr>
                <div class="text-center m-2">
                    <button type="submit" class="btn btn-success me-2 btn-register"><i class="fa fa-save"></i> Kaydet
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $('#update-profile-form input').blur(function () {
            if (!$(this).val()) {
                $(this).addClass('alert-danger');
            } else {
                $(this).removeClass('alert-danger');
            }

            if($(this).attr('id') == 'current_password' || $(this).attr('id') == 'password' || $(this).attr('id') == 'password_confirmation') {
                $(this).removeClass('alert-danger');
            }

            if ($('#current_password').val() || $('#password').val() || $('#password_confirmation').val()) {
               if (!$(this).val()) {
                   $(this).addClass('alert-danger');
               }
            } else {
                $(this).removeClass('alert-danger');
            }

        });

        $('#current_password, #password, #password_confirmation').on('keyup change', function() {
            if ($(this).val()) {
                $('#current_password, #password, #password_confirmation').attr('required', true);
            } else {
                $('#current_password, #password, #password_confirmation').attr('required', false);
                $('#current_password, #password, #password_confirmation').removeClass('alert-danger');
            }


        });

        $('#user_about_text').blur(function () {
            if (!$(this).val()) {
                $(this).addClass('alert-danger');
            } else {
                $(this).removeClass('alert-danger');
            }
        });

        $('#charNum').text(500 - $('#user_about_text').val().length);

        function countChar (val) {
            var len = val.value.length;
            if (len >= 500) {
                val.value = val.value.substring(0, 500);
            } else {
                $('#charNum').text(500 - len);
            }
        }
    </script>
@endsection