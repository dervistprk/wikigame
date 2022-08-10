@extends('layouts.backend')
@section('title', 'Oyunlar')
@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="alert alert-success m-2 alert-dismissible fade show text-center">
                        {!! session()->get('message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div class="m-2">
            <a href="{{route('admin.create-game')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Oyun Ekle</a>
        </div>
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-gamepad"></i>
                Kayıtlı Oyunlar
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table-responsive">
                    <thead>
                    <tr>
                        <th>Kapak Resmi</th>
                        <th>Adı</th>
                        <th>Kategori</th>
                        <th>Geliştirici</th>
                        <th>Dağıtıcı</th>
                        <th>Website</th>
                        <th>Çıkış Tarihi</th>
                        <th>Yaş Sınırı</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                        @php
                            $target = $game;
                            $route  = 'game';
                        @endphp
                        <tr class="@if($game->status == 0) alert-danger @endif">
                            <td>
                                <img src="{{ $game->cover_image }}" alt="{{ $game->name }} Kapak Resmi" title="{{ $game->name }} Kapak Resmi" class="img-fluid img-thumbnail" width="150" height="200">
                            </td>
                            <td class="font-weight-bold">
                                {{ $game->name }}
                                @if($game->status == 0)
                                    <span class="text-danger d-inline-block p-1 m-1"><i class="fas fa-times"></i> Pasif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.edit-category', [$game->category->id]) }}" class="text-primary text-decoration-none">{{ $game->category->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.edit-developer', [$game->developer->id]) }}" class="text-primary text-decoration-none">{{ $game->developer->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.edit-publisher', [$game->publisher->id]) }}" class="text-primary text-decoration-none">{{ $game->publisher->name }}</a>
                            </td>
                            <td>
                                <a href="{{ $game->details->website }}" class="text-primary text-decoration-none" target="_blank">{{ $game->name }}</a>
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($game->details->release_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                <img src="{{asset('assets/pegi_ratings/pegi_') . $game->details->age_rating . '.png'}}" class="img-fluid" alt="pegi_rating" width="30" height="30" title="{{ $game->details->age_rating }} yaş ve üzeri">
                            </td>
                            <td>
                                <div>
                                    @if($game->status == 1)
                                        <div>
                                            <a target="_blank" href="{{ route('game', [$game->slug]) }}" class="btn btn-sm btn-success" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                                        </div>
                                    @endif
                                    <div class="mt-1">
                                        <a href="{{ route('admin.edit-game', [$game->id]) }}" class="btn btn-sm btn-primary" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                                    </div>
                                    <div class="mt-1">
                                        <a href="#" data-id="{{$game->id}}" class="btn btn-danger delete" data-toggle="modal" data-target="#delete{{$target->slug}}Modal_{{$target->id}}"><i class="fas fa-trash"></i> Sil</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @include('backend.modals.deleteConfirmation')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
