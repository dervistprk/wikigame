@extends('layouts.app')
@section('title', 'Üye Ol')
@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <form class="game-info rounded col-sm-8 mt-2 needs-validation" novalidate action="{{ route('register-post') }}" method="post" id="register-form">
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
            <h2 class="text-center dev-header mt-1">Üye Kayıt Formu</h2>
            <div class="m-4">
                <div class="row">
                    <div class="col">
                        <label for="email" class="form-label fw-bold">E-Posta</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Adresinizi Girin" aria-describedby="emailHelp" value="{{ old('email') }}" required/>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">
                            <ul>
                                <li>E-Posta adresinizi başka kaynaklarla asla paylaşmayız.</li>
                                <li>Lütfen geçerli bir e-posta adresi giriniz.</li>
                            </ul>
                        </small>
                    </div>
                    <div class="col">
                        <label for="user_name" class="form-label fw-bold">Kullanıcı Adı</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                            <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Kullanıcı Adı Girin" aria-describedby="user_name_help" value="{{ old('user_name') }}" minlength="3" maxlength="255" pattern="[\x00-\x7F]+" required/>
                        </div>
                        <small id="user_name_help" class="form-text text-muted">Lütfen Türkçe karakter kullanmayınız.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="password" class="form-label fw-bold">Şifre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" id="password" minlength="6" maxlength="255" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*" placeholder="Şifre Girin" autocomplete="new-password" required/>
                            <span class="input-group-text" style="cursor: pointer" id="show-eye-1">
                                    <i class="far fa-eye"></i>
                                </span>
                            <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye-1">
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
                        <label for="password_confirmation" class="form-label fw-bold">Şifre Tekrarı</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="6" maxlength="255" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*" autocomplete="new-password" placeholder="Şifre Tekrarını Girin" required/>
                            <span class="input-group-text" style="cursor: pointer" id="show-eye-2">
                                    <i class="far fa-eye"></i>
                            </span>
                            <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye-2">
                                    <i class="far fa-eye-slash"></i>
                            </span>
                        </div>
                        <div class="alert alert-danger d-none mt-2" id="password-confirmation-alert">
                            Şifre tekrarları eşleşmiyor.
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="dev-header">Kişisel Bilgiler</h5>
                <div class="row">
                    <div class="col">
                        <label for="name" class="form-label fw-bold">Ad</label>
                        <input type="text" name="name" class="form-control" id="name" minlength="2" maxlength="255" value="{{ old('name') }}" required/>

                    </div>
                    <div class="col">
                        <label for="surname" class="form-label fw-bold">Soyad</label>
                        <input type="text" name="surname" class="form-control" id="surname" minlength="2" maxlength="255" value="{{ old('surname') }}" required/>

                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <label for="birth_day" class="form-label fw-bold">Doğum Tarihi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="text" name="birth_day" class="form-control date-picker" id="birth_day" value="{{ old('birth_day') }}" required/>
                        </div>
                    </div>
                    <div class="col">
                        <label for="gender" class="form-label fw-bold">Cinsiyet</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="" hidden>Lütfen Seçiniz</option>
                                <option value="erkek" @if(old('gender') == 'erkek') selected @endif>Erkek</option>
                                <option value="kadin" @if(old('gender') == 'kadin') selected @endif>Kadın</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col mt-2">
                    <label for="user_about_text" class="form-label fw-bold">Hakkımda</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        <textarea class="form-control" name="about" id="user_about_text" rows="7" minlength="30" maxlength="500" placeholder="Hakkınızda tanıtıcı kısa bir yazı yazın." onkeyup="countChar(this)" required>{{ old('about') }}</textarea>
                    </div>
                    <small id="emailHelp" class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
                    <span id="charNum" class="text-muted d-inline-block float-end">500</span>
                </div>
                <hr>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreement_confirmation" required/>
                    <label class="form-label" for="agreement_confirmation"><a href="" class="game-detail-links text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalLong">Kullanıcı sözleşmesini</a> okudum ve kabul ediyorum.</label>
                </div>
                <div class="text-center m-2">
                    <button type="submit" class="btn btn-success me-2 btn-register"><i class="fa fa-user"></i> Üye Ol
                    </button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Sıfırla</button>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="google-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-danger m-2" id="google-btn" href="{{ route('redirect-google') }}">
                        <i class="fab fa-google"></i> Google ile Üye Ol
                    </a>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="facebook-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-primary m-2" id="facebook-btn" href="{{ route('redirect-facebook') }}">
                        <i class="fab fa-facebook"></i> Facebook ile Üye Ol
                    </a>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="github-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-secondary m-2" id="github-btn" href="{{ route('redirect-github') }}">
                        <i class="fab fa-github"></i> Github ile Üye Ol
                    </a>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="linkedin-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-primary m-2" id="linkedin-btn" href="{{ route('redirect-linkedin') }}">
                        <i class="fab fa-linkedin"></i> LinkedIn ile Üye Ol
                    </a>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-body" id="exampleModalLongTitle">Site Kuralları</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-body">
                        <p>
                            Lütfen aşağıda belirtilen kuralları dikkatle okuyunuz.<br>
                            Kuralları okumamanızdan kaynaklı bir sorunda WikiGame herhangi bir sorumluluk kabul etmemektedir.
                        </p>
                        <hr>
                        <ul>
                            <li>E-posta adresimin site veritabanı tarafından kaydedilmesini kabul ediyorum.</li>
                            <li>Doğum tarihi, cinsiyet gibi özel bilgilerimin kaydedilmesini kabul ediyorum.</li>
                            <li>Küfür, argo vb. kötü sözleri kullanmayacağımı kabul ediyorum.</li>
                            <li>Moderatörlerle tartışmaya girmeyeceğimi, hakkımda verdikleri kararlara saygı duyacağımı kabul ediyorum.</li>
                            <li>Diğer kullanıcılara saygısızlık yapmayacağımı kabul ediyorum.</li>
                            <li>Diğer kullanıcılarla din, siyaset, ırkçılık gibi konularda tartışma çıkarmayacağımı kabul ediyorum</li>
                            <li>Özel oyun haberleri gibi önemli gelişmelerde Wikigame'den e-posta almak istediğimi kabul ediyorum.</li>
                        </ul>
                        <hr>
                        <p>
                            Yukarıda yazılı kurallardan herhangi birine uymadığım takdirde siteden
                            <span class="text-warning">geçici</span> veya
                            <span class="text-danger">kalıcı</span> olarak yasaklanabileceğimi kabul ediyorum.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
       $('#register-form input').blur(function() {
          if (!$(this).val()) {
             $(this).addClass('alert-danger');
          } else {
             $(this).removeClass('alert-danger');
          }
       });

       $('#user_about_text').blur(function() {
          if (!$(this).val()) {
             $(this).addClass('alert-danger');
          } else {
             $(this).removeClass('alert-danger');
          }
       });

       function countChar(val) {
          var len = val.value.length;
          if (len >= 500) {
             val.value = val.value.substring(0, 500);
          } else {
             $('#charNum').text(500 - len);
          }
       }

       var social_btn         = $('#google-btn, #facebook-btn, #github-btn, #linkedin-btn');
       var social_btn_overlay = $('#google-btn-overlay, #facebook-btn-overlay, #github-btn-overlay, #linkedin-btn-overlay');

       social_btn.addClass('disabled');
       social_btn.css('pointer-events', 'none');

       $('#agreement_confirmation').change(function() {
          var is_checked = $('#agreement_confirmation')[0].checked;
          if (is_checked) {
             social_btn.removeClass('disabled');
             social_btn.css('pointer-events', 'auto');
             social_btn_overlay.tooltip('disable');
          } else {
             social_btn.addClass('disabled');
             social_btn.css('pointer-events', 'none');
             social_btn_overlay.tooltip('enable');
          }
       });

       for (var i = 1; i <= 2; i++) {
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

       $('#password, #password_confirmation').on('keyup', function() {
          if ($('#password').val() != $('#password_confirmation').val()) {
             $('#password-confirmation-alert').removeClass('d-none');
          } else
             $('#password-confirmation-alert').addClass('d-none');
       });
    </script>
@endsection