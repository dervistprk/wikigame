@extends('layouts.backend')
@section('title', 'Oyunlar')
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success m-2">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="m-2">
        <a href="{{route('admin.create-game')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Oyun Ekle</a>
    </div>
    <div class="card mb-4 m-2">
        <div class="card-header font-weight-bold text-secondary">
            <i class="fas fa-gamepad"></i>
            Kayıtlı Oyunlar
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
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
                    <tr>
                        <td>
                            <img src="{{ $game->cover_image }}" alt="{{ $game->name }} Kapak Resmi" title="{{ $game->name }} Kapak Resmi" class="mt-1" width="100" height="150">
                        </td>
                        <td class="font-weight-bold">
                            {{ $game->name }}
                            @if($game->status == 0)
                                <span class="alert-danger d-inline-block p-1 m-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.edit-category', [$game->category->id]) }}" class="text-primary text-decoration-none">{{ $game->category->name }}</a></td>
                        <td><a href="{{ route('admin.edit-developer', [$game->developer->id]) }}" class="text-primary text-decoration-none">{{ $game->developer->name }}</a></td>
                        <td><a href="{{ route('admin.edit-publisher', [$game->publisher->id]) }}" class="text-primary text-decoration-none">{{ $game->publisher->name }}</a></td>
                        <td>
                            <a href="{{ $game->details->website }}" class="text-primary text-decoration-none" target="_blank">{{ $game->name }}</a>
                        </td>
                        <td>{{ Carbon\Carbon::parse($game->details->release_date)->format('d/m/Y') }}</td>
                        <td><img src="{{asset('assets/pegi_ratings/pegi_') . $game->details->age_rating . '.png'}}" alt="pegi_rating" width="25" height="25" title="{{ $game->details->age_rating }} yaş ve üzeri"></td>
                        <td>
                            @if($game->status == 1)
                                <div>
                                    <a target="_blank" href="{{ route('game', [$game->slug]) }}" class="btn btn-sm btn-success" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                                </div>
                            @endif
                            <div class="mt-1">
                                <a href="{{ route('admin.edit-game', [$game->id]) }}" class="btn btn-sm btn-primary" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                            </div>
                            <div class="mt-1">
                                <a href="{{ route('admin.delete-game', [$game->id]) }}" class="btn btn-sm btn-danger pb-1 pt-1 ps-4 pe-4" onclick="return confirm('{{ $game->name }} oyununu silmek istediğinizden emin misiniz?')" title="Sil"><i class="fas fa-trash"></i> Sil</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
