@extends('layouts.app')
@section('title', 'Doğrulama E-Posta\'sı Gönder')
@section('content')
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <form class="game-info rounded col-sm-8 mt-2" action="{{ route('resend-verification') }}" method="post" id="resend-email-form">
            @if($errors->any())
                <div class="alert alert-danger mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-warning m-2">
                    {!! session()->get('message') !!}
                </div>
            @endif
            @csrf
            <h2 class="text-center dev-header mt-1">Doğrulama E-Postası Gönder</h2>
            <div class="form-group">
                <label for="email">E-Posta</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Adresinizi Girin" value="{{ old('email') }}" required/>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi Girin" required/>
            </div>
            <div class="text-center m-2">
                <button type="submit" class="btn btn-success me-2 btn-register"><i class="fa fa-paper-plane"></i> Gönder</button>
            </div>
        </form>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $('#resend-email-form input').blur(function()
        {
            if(!$(this).val()) {
                $(this).addClass('alert-danger');
            } else {
                $(this).removeClass('alert-danger');
            }
        });
    </script>
@endsection