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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body style="background: ghostwhite">
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
                                    <div class="alert alert-danger text-center">
                                        {{$errors->first()}}
                                    </div>
                                @endif
                                @if(session()->has('message'))
                                    <div class="alert alert-warning m-2 alert-dismissible fade show">
                                        {!! session()->get('message') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif
                                <form method="post" action="{{ route('admin.login.post') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="email" type="email" name="email" placeholder="E-Posta Adresinizi Giriniz"/>
                                        <label for="email">E-Posta</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" type="password" name="password" placeholder="Şifre"/>
                                        <label for="password">Şifre</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary col-sm-4">Giriş</button>
                                        <div class="col-sm-4 d-inline-block">
                                            <input type="checkbox" class="" name="remember_token" id="remember"/>
                                            <label for="remember">Beni Hatırla</label>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/scripts.js') }}js/scripts.js"></script>
</body>
</html>
