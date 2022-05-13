@extends('layouts.backend')
@section('title', 'Geliştiriciler')
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success m-2">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="m-2">
        <a href="{{route('admin.create-developer')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Geliştirici Ekle</a>
    </div>
    <div class="card mb-4 m-2">
        <div class="card-header font-weight-bold text-secondary">
            <i class="fas fa-calculator"></i>
            Kayıtlı Geliştiriciler
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th></th>
                    <th>Adı</th>
                    <th>Oyun Sayısı</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($developers as $developer)
                    <tr>
                        <td>
                            <img src="{{ $developer->image }}" alt="geliştirici resmi" title="{{ $developer->name }}" width="100" height="75">
                        </td>
                        <td class="font-weight-bold">
                            {{ $developer->name }}
                            @if($developer->status == 0)
                                <span class="alert-danger d-inline-block p-1 m-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                            @endif
                        </td>
                        <td class="font-weight-bold">{{ $developer->games_count }}</td>
                        <td>
                            @if($developer->status == 1)

                                <a target="_blank" href="{{ route('developer', [$developer->slug]) }}" class="btn btn-sm btn-success mt-4 ms-1 p-2" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                            @endif
                            <a href="{{ route('admin.edit-developer', [$developer->id]) }}" class="btn btn-sm btn-primary mt-4 ms-3 pt-2 pb-2 ps-3 pe-3" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                            <a href="{{ route('admin.delete-developer', [$developer->id]) }}" class="btn btn-sm btn-danger mt-4 ms-3 ps-4 pe-4 pt-2 pb-2" onclick="return confirm('{{ $developer->name }} geliştiricisini silmek istediğinizden emin misiniz?')" title="Sil"><i class="fas fa-trash"></i> Sil</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
