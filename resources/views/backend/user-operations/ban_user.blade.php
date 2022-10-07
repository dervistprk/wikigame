@extends('layouts.backend')
@section('title', 'Kullanıcı Yasakla')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" method="post" novalidate action="{{ route('admin.ban-user', $user->id) }}">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger text-center alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
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
                    <i class="fas fa-user-slash"></i>
                    Kullanıcı Yasakla <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="email" class="text-primary form-label font-weight-bold">E-Posta</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="E-Posta" value="{{ $user->email }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="user_name" class="text-primary form-label font-weight-bold">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Kullanıcı Adı" value="{{ $user->user_name }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name" class="text-primary form-label font-weight-bold">Adı</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Ad" value="{{ $user->name }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="surname" class="text-primary form-label font-weight-bold">Soyadı</label>
                                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad" value="{{ $user->surname }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ban_reason" class="text-primary form-label font-weight-bold">Yasak Sebebi*</label>
                            <textarea class="form-control" id="ban_reason" name="ban_reason" placeholder="Yasak sebebini yazın" required></textarea>
                            <small class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.user-operations')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection