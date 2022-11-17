@extends('layouts.app')
@section('title', __('Doğrulama E-Posta\'sı Gönder'))
@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <form class="game-info rounded mt-2 needs-validation col-sm-8" novalidate
              action="{{ route('resend-verification') }}" method="post" id="resend-email-form">
            <div class="m-4">
                @if($errors->any())
                    <div class="row justify-content-center">
                        <div class="col-sm-6">
                            <div class="alert alert-danger mt-2 alert-dismissible fade show">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-warning m-2 alert-dismissible fade show">
                        {!! session()->get('message') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <h2 class="text-center dev-header mt-1">{{ __('Doğrulama E-Posta\'sı Gönder') }}</h2>
                <div class="justify-content-center align-items-center col-sm-6 offset-sm-3">
                    <div class="mb-3">
                        <label for="email" class="fw-bold form-label">{{ __('E-Posta') }}</label>
                        <div class="input-group mt-2">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="{{ __('E-Posta Adresinizi Girin') }}" value="{{ old('email') }}" required/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="fw-bold form-label">{{ __('Şifre') }}</label>
                        <div class="input-group mt-2">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" minlength="6"
                                   maxlength="255" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*"
                                   placeholder="{{ __('Şifrenizi Girin') }}" required/>
                            <span class="input-group-text" style="cursor: pointer" id="show-eye">
                                <i class="far fa-eye"></i>
                            </span>
                            <span class="input-group-text d-none" style="cursor: pointer" id="hide-eye">
                                <i class="far fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-center m-2">
                    <button type="submit" class="btn btn-success me-2 btn-register">
                        <i class="fa fa-envelope"></i> {{ __('Gönder') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $('#resend-email-form input').blur(function() {
          if (!$(this).val()) {
             $(this).addClass('alert-danger');
          } else {
             $(this).removeClass('alert-danger');
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