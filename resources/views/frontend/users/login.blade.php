@extends('layouts.app')
@section('title', 'Giriş Yap')
@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <form class="game-info rounded col-sm-8 mt-2" action="{{ route('login-post') }}" method="post" id="login-form">
            <div class="m-4">
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
                @if(session()->has('message'))
                    <div class="alert alert-warning alert-dismissible m-2 fade show">
                        {!! session()->get('message') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <h2 class="text-center dev-header mt-1">Giriş Yap</h2>
                <div class="justify-content-center align-items-center col-sm-8 offset-sm-2">
                    <label for="email" class="font-weight-bold">E-Posta</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Adresinizi Girin" value="{{ old('email') }}" required/>
                    </div>
                    <label for="password" class="font-weight-bold">Şifre</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi Girin" required/>
                        <span class="input-group-text" style="cursor: pointer" id="show-eye">
                            <i class="far fa-eye"></i>
                         </span>
                        <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye">
                            <i class="far fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <div class="col text-center m-2">
                    <button type="submit" class="btn btn-success btn-register col-sm-3">
                        <i class="fas fa-sign-in-alt"></i> Giriş Yap
                    </button>
                    <div class="col-sm-3 d-inline-block">
                        <input type="checkbox" class="form-check-input" name="remember_token" id="remember"/>
                        <label for="remember" class="form-check-label">Beni Hatırla</label>
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="agreement_confirmation"/>
                        <label class="form-label" for="agreement_confirmation"><a href="" class="game-detail-links text-decoration-none" data-bs-toggle="modal" data-bs-target="#user-agreement-modal">Kullanıcı sözleşmesini</a> okudum ve kabul ediyorum.</label>
                    </div>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="google-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-danger m-2" id="google-btn" href="{{ route('redirect-google') }}">
                        <i class="fab fa-google"></i> Google ile Giriş Yap
                    </a>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="facebook-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-primary m-2" id="facebook-btn" href="{{ route('redirect-facebook') }}">
                        <i class="fab fa-facebook"></i> Facebook ile Giriş Yap
                    </a>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="github-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-secondary m-2" id="github-btn" href="{{ route('redirect-github') }}">
                        <i class="fab fa-github"></i> Github ile Giriş Yap
                    </a>
                </div>
                <div class="d-grid gap-2 mx-auto text-center" id="linkedin-btn-overlay" data-toggle="tooltip" data-placement="top" title="Lütfen kullanıcı sözleşmesini kabul edin">
                    <a class="btn btn-outline-primary m-2" id="linkedin-btn" href="{{ route('redirect-linkedin') }}">
                        <i class="fab fa-linkedin"></i> LinkedIn ile Giriş Yap
                    </a>
                </div>
            </div>
        </form>
        @include('frontend.modals.userAgreement')
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $('#login-form input').blur(function() {
          if (!$(this).val()) {
             $(this).addClass('alert-danger');
          } else {
             $(this).removeClass('alert-danger');
          }
       });

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

       $('#show-eye').click(function() {
          var input    = $(this).siblings($('input[type=\'password\']'));
          var hide_eye = $(this).siblings($('#hide_eye'));
          $(this).addClass('d-none');
          hide_eye.removeClass('d-none');
          input.attr('type', 'text');
       });

       $('#hide-eye').click(function() {
          var input    = $(this).siblings($('input[type=\'text\']'));
          var show_eye = $(this).siblings($('#show_eye'));
          $(this).addClass('d-none');
          show_eye.removeClass('d-none');
          input.attr('type', 'password');
       });
    </script>
@endsection
