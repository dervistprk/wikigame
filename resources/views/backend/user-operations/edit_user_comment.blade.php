@extends('layouts.backend')
@section('title', 'Yorum Düzenle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" method="post" novalidate action="{{ route('admin.edit-user-comment', $comment->id) }}">
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
                    <i class="fas fa-comment"></i>
                    Yorum Düzenle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body">
                    <div class="col-sm">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name" class="text-primary form-label font-weight-bold">Adı</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Yorum Yapan Kişi Adı" value="{{ $comment->user->name }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="surname" class="text-primary form-label font-weight-bold">Soyadı</label>
                                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Yorum Yapan Kişi Soyadı" value="{{ $comment->user->surname }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="email" class="text-primary form-label font-weight-bold">E-Posta</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Yorum Yapan Kişi E-Posta" value="{{ $comment->user->email }}" readonly style="cursor: not-allowed">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="body" class="text-primary form-label font-weight-bold">Yorum İçeriği*</label>
                            <textarea class="form-control" id="body" name="body" placeholder="Yorumu Düzenleyin" required>{!! $comment->body !!}</textarea>
                            <small class="form-text text-muted d-inline-block">En az 30 karakter uzunluğunda olmalıdır.</small>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="is_verified" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="is_verified" name="is_verified">
                                        <option @if($comment->is_verified == 0) selected="selected" @endif value="0">Pasif</option>
                                        <option @if($comment->is_verified == 1) selected="selected" @endif value="1" @if($comment->user->is_banned == 1) disabled @endif>Aktif</option>
                                    </select>
                                    @if($comment->user->is_banned == 1)
                                        <div class="alert alert-danger mt-2">
                                            <i class="fas fa-exclamation-triangle"></i> Yasaklı kullanıcıların yorumları aktive edilemez!
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.user-comments', $comment->user->id)}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection