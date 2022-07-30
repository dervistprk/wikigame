@extends('layouts.app')
@section('title', 'Üye Ol')
@section('content')
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <form class="game-info rounded col-sm-8 mt-2" action="{{ route('register-post') }}" method="post" id="register-form">
            @if($errors->any())
                <div class="alert alert-danger mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            @csrf
            <h2 class="text-center dev-header mt-1">Üye Kayıt Formu</h2>
            <div class="m-4">
                <div class="form-group">
                    <label for="email">E-Posta</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Adresinizi Girin" aria-describedby="emailHelp" value="{{ old('email') }}" required/>
                    <small id="emailHelp" class="form-text text-muted">E-Posta adresinizi başka kaynaklarla asla paylaşmayız.</small>
                </div>
                <div class="form-group">
                    <label for="user_name">Kullanıcı Adı</label>
                    <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Kullanıcı Adı Girin" value="{{ old('user_name') }}" required/>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="password">Şifre</label>
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
                        <label for="password_confirmation">Şifre Tekrarı</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Şifre Tekrarını Girin" required/>
                    </div>
                </div>
                <hr>
                <h5 class="dev-header">Kişisel Bilgiler</h5>
                <div class="form-row">
                    <div class="col">
                        <label for="name">Ad</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required/>
                    </div>
                    <div class="col">
                        <label for="surname">Soyad</label>
                        <input type="text" name="surname" class="form-control" id="surname" value="{{ old('surname') }}" required/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mt-2">
                        <label for="birth_day">Doğum Tarihi</label>
                        <input type="date" name="birth_day" class="form-control" id="birth_day" value="{{ old('birth_day') }}" required/>
                    </div>
                    <div class="col mt-2">
                        <label for="gender">Cinsiyet</label>
                        <select class="form-control" name="gender" id="gender" required>
                            <option value="">Lütfen Seçiniz</option>
                            <option value="erkek" @if(old('gender') == 'erkek') selected @endif>Erkek</option>
                            <option value="kadin" @if(old('gender') == 'kadin') selected @endif>Kadın</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="user_about_text">Hakkımda</label>
                    <textarea class="form-control" name="about" id="user_about_text" rows="7" placeholder="Hakkınızda tanıtıcı kısa bir yazı yazın." onkeyup="countChar(this)" required>{{ old('about') }}</textarea>
                    <small id="emailHelp" class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
                    <span id="charNum" class="text-muted d-inline-block float-end">500</span>
                </div>
                <hr>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreement_confirmation" required/>
                    <label class="form-check-label" for="agreement_confirmation"><a href="" class="game-detail-links text-decoration-none" data-toggle="modal" data-target="#exampleModalLong">Site kurallarını</a> okudum ve kabul ediyorum.</label>
                </div>
                <div class="text-center m-2">
                    <button type="submit" class="btn btn-success me-2 btn-register"><i class="fa fa-user"></i> Üye Ol</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Sıfırla</button>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-body" id="exampleModalLongTitle">Site Kuralları</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-body">
                        <ul>
                            <li>E-posta adresimin site veritabanı tarafından kaydedilmesini kabul ediyorum.</li>
                            <li>Doğum tarihi, cinsiyet gibi özel bilgilerimin kaydedilmesini kabul ediyorum.</li>
                            <li>Küfür, argo vb. kötü sözleri kullanmayacağımı kabul ediyorum.</li>
                            <li>Moderatörlerle tartışmaya girmeyeceğimi, hakkımda verdikleri kararlara saygı duyacağımı kabul ediyorum.</li>
                            <li>Diğer kullanıcılara saygısızlık yapmayacağımı kabul ediyorum.</li>
                            <li>Diğer kullanıcılarla din, siyaset, ırkçılık gibi konularda tartışma çıkarmayacağımı kabul ediyorum</li>
                        </ul>
                        <hr>
                        <p>
                            Yukarıda yazılı kurallardan herhangi birine uymadığım takdirde siteden <span class="text-warning">geçici</span> veya <span class="text-danger">kalıcı</span> olarak yasaklanabileceğimi kabul ediyorum.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">

        $('#register-form input').blur(function()
        {
            if(!$(this).val()) {
                $(this).addClass('alert-danger');
            } else {
                $(this).removeClass('alert-danger');
            }
        });

        $('#user_about_text').blur(function()
        {
            if(!$(this).val()) {
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
    </script>
@endsection