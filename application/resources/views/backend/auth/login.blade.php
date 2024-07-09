<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="WikiGame Giriş Ekranı"/>
    <meta name="author" content="dervistprk"/>
    <title>Yönetici Girişi - WikiGame</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <script src="{{ asset('js/font-awesome-5.15.3.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-4.3.1.css') }}">
</head>
<body class="bg-light">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Yönetici Girişi</h3>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger text-center alert-dismissible fade show">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif
                                @if(session()->has('message'))
                                    <div class="alert alert-warning alert-dismissible fade show">
                                        {!! session()->get('message') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif
                                <form method="post" class="needs-validation" novalidate
                                      action="{{ route('admin.login-post') }}">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <div class="form-floating flex-grow-1">
                                            <input class="form-control" id="email" type="email" name="email"
                                                   placeholder="E-Posta Adresinizi Giriniz" required/>
                                            <label for="email">E-Posta</label>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <div class="form-floating flex-grow-1">
                                            <input class="form-control" id="password" type="password" name="password"
                                                   minlength="6" maxlength="255"
                                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*" placeholder="Şifre"
                                                   required/>
                                            <label for="password">Şifre</label>
                                        </div>
                                        <span class="input-group-text" style="cursor: pointer" id="show-eye">
                                             <i class="far fa-eye"></i>
                                        </span>
                                        <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye">
                                             <i class="far fa-eye-slash"></i>
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary col-sm-4">
                                            <i class="fa fa-sign-in-alt"></i> Giriş
                                        </button>
                                        <div class="col-sm-4 d-inline-block ms-2">
                                            <input type="checkbox" class="form-check-input form-check-inline"
                                                   name="remember_token" id="remember"/>
                                            <label for="remember" class="form-check-label">Beni Hatırla</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3 text-secondary">WikiGame Yönetim Paneli Girişi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap-4.3.1.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function() {
      (function() {
         'use strict';
         window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
               form.addEventListener('submit', function(event) {
                  if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();
                  }
                  form.classList.add('was-validated');
               }, false);
            });
         }, false);
      })();

      $('#show-eye').click(function() {
         var input    = $('#password');
         var hide_eye = $('#hide-eye');
         $(this).addClass('d-none');
         hide_eye.removeClass('d-none');
         input.attr('type', 'text');
      });

      $('#hide-eye').click(function() {
         var input    = $('#password');
         var show_eye = $('#show-eye');
         $(this).addClass('d-none');
         show_eye.removeClass('d-none');
         input.attr('type', 'password');
      });
   });
</script>
</body>
</html>
