@extends('layouts.app')
@section('title', 'Profil Güncelle')
@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <form class="game-info rounded col-sm-10 mt-2 needs-validation" novalidate
              action="{{ route('update-profile') }}" method="post" id="update-profile-form">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger mt-2 alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
            @csrf
            <div class="btn-group h-100 d-flex align-items-center justify-content-center m-2" role="group">
                <a type="button" class="btn btn-primary btn-lg active" href=" {{route('update-profile')}}"
                   style="pointer-events: none">Bilgilerim</a>
                <a type="button" class="btn btn-danger btn-lg" href="#">Favorilerim</a>
                <a type="button" class="btn btn-info btn-lg" href="#">Yorumlarım</a>
            </div>
            <h2 class="dev-header text-center mt-2">Profil Bilgilerimi Güncelle</h2>
            <div class="m-4">
                <div class="row">
                    <div class="col">
                        <label for="email" class="form-label fw-bold">E-Posta</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" id="email"
                                   aria-describedby="emailHelp" value="{{ $user->email }}" readonly
                                   style="cursor: not-allowed"/>
                        </div>
                    </div>
                    <div class="col">
                        <label for="user_name" class="form-label fw-bold">Kullanıcı Adı</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                            <input type="text" name="user_name" class="form-control" id="user_name"
                                   placeholder="Kullanıcı Adı Girin" value="{{ $user->user_name }}" minlength="3"
                                   maxlength="255" pattern="[\x00-\x7F]+" readonly style="cursor: not-allowed"/>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <label for="current_password" class="form-label fw-bold">Mevcut Şifre (*)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                   placeholder="Mevcut Şifrenizi Girin" minlength="6" maxlength="255"
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*"/>
                            <span class="input-group-text" style="cursor: pointer" id="show-eye-1">
                                    <i class="far fa-eye"></i>
                                </span>
                            <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye-1">
                                    <i class="far fa-eye-slash"></i>
                                </span>
                        </div>
                    </div>
                    <div class="col">
                        <label for="password" class="form-label fw-bold">Yeni Şifre (*)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control pr-password"
                                   placeholder="Yeni Şifrenizi Girin" minlength="6" maxlength="255"
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*"/>
                            <span class="input-group-text" style="cursor: pointer" id="show-eye-2">
                                <i class="far fa-eye"></i>
                            </span>
                            <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye-2">
                                <i class="far fa-eye-slash"></i>
                            </span>
                        </div>
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
                        <label for="password_confirmation" class="form-label fw-bold">Yeni Şifre Tekrarı (*)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Yeni Şifre Tekrarını Girin" minlength="6"
                                   maxlength="255" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*"/>
                            <span class="input-group-text" style="cursor: pointer" id="show-eye-3">
                                <i class="far fa-eye"></i>
                            </span>
                            <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye-3">
                                <i class="far fa-eye-slash"></i>
                            </span>
                        </div>
                        <div class="alert alert-danger d-none mt-2" id="password-confirmation-alert">
                            Şifre tekrarları eşleşmiyor.
                        </div>
                    </div>
                    <span class="float-end small form-text text-muted">* Şifrenizi değiştirmek istemiyorsanız boş bırakın.</span>
                </div>
                <hr>
                <h5 class="dev-header">Kişisel Bilgiler</h5>
                <div class="row">
                    <div class="col">
                        <label for="name" class="form-label fw-bold">Ad</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}"
                               minlength="2" maxlength="255" required/>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="surname" class="form-label fw-bold">Soyad</label>
                            <input type="text" name="surname" class="form-control" id="surname"
                                   value="{{ $user->surname }}" minlength="2" maxlength="255" required/>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="birth_day" class="form-label fw-bold">Doğum Tarihi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="birth_day" class="form-control date-picker" id="birth_day"
                                       value="{{ date('Y-m-d', strtotime($user->birth_day)) }}" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="gender" class="form-label fw-bold">Cinsiyet</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user-friends"></i></span>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="" hidden>Lütfen Seçiniz</option>
                                <option value="erkek" @if($user->gender == 'erkek') selected @endif>Erkek</option>
                                <option value="kadin" @if($user->gender == 'kadin') selected @endif>Kadın</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col mt-2">
                    <label for="user_about_text" class="form-label fw-bold">Hakkımda</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-info-circle"></i></span>
                        <textarea class="form-control" name="about" id="user_about_text" rows="7" minlength="30"
                                  maxlength="500" placeholder="Hakkınızda tanıtıcı kısa bir yazı yazın."
                                  onkeyup="countChar(this)" required>{{ $user->about }}</textarea>
                    </div>
                    <small id="emailHelp"
                           class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
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
       $('#charNum').text(500 - $('#user_about_text').val().length);

       function countChar(val) {
          var len = val.value.length;
          if (len >= 500) {
             val.value = val.value.substring(0, 500);
          } else {
             $('#charNum').text(500 - len);
          }
       }

       $('#update-profile-form input').blur(function() {
          if (!$(this).val()) {
             $(this).addClass('alert-danger');
          } else {
             $(this).removeClass('alert-danger');
          }

          if ($(this).attr('id') == 'current_password' || $(this).attr('id') == 'password' || $(this).attr('id') == 'password_confirmation') {
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

       $('#user_about_text').blur(function() {
          if (!$(this).val()) {
             $(this).addClass('alert-danger');
          } else {
             $(this).removeClass('alert-danger');
          }
       });

       for (var i = 1; i <= 3; i++) {
          $('#show-eye-' + i).click(function() {
             var input    = $(this).siblings($('input[type=\'password\']'));
             var hide_eye = $(this).siblings($('#hide_eye'));
             $(this).addClass('d-none');
             hide_eye.removeClass('d-none');
             input.attr('type', 'text');
          });

          $('#hide-eye-' + i).click(function() {
             var input    = $(this).siblings($('input[type=\'text\']'));
             var show_eye = $(this).siblings($('#show_eye'));
             $(this).addClass('d-none');
             show_eye.removeClass('d-none');
             input.attr('type', 'password');
          });
       }

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
