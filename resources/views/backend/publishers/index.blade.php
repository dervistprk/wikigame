@extends('layouts.backend')
@section('title', 'Dağıtıcılar')
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success m-2 alert-dismissible fade show">
            {!! session()->get('message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="m-2">
        <a href="{{route('admin.create-publisher')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Dağıtıcı Ekle</a>
    </div>
    <div class="card mb-4 m-2">
        <div class="card-header font-weight-bold text-secondary">
            <i class="fas fa-newspaper"></i>
            Kayıtlı Dağıtıcılar
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
                @foreach($publishers as $publisher)
                    <tr>
                        <td>
                            <img src="{{ $publisher->image }}" alt="geliştirici resmi" title="{{ $publisher->name }}" width="125" height="100">
                        </td>
                        <td class="font-weight-bold">
                            {{ $publisher->name }}
                            @if($publisher->status == 0)
                                <span class="alert-danger d-inline-block p-1 m-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                            @endif
                        </td>
                        <td class="font-weight-bold">{{ $publisher->games_count }}</td>
                        <td>
                            @if($publisher->status == 1)
                                <a target="_blank" href="{{ route('publisher', [$publisher->slug]) }}" class="btn btn-sm btn-success mt-4 ms-1 p-2" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                            @endif
                            <a href="{{ route('admin.edit-publisher', [$publisher->id]) }}" class="btn btn-sm btn-primary mt-4 ms-3 pt-2 pb-2 ps-3 pe-3" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                            <a href="{{ route('admin.delete-publisher', [$publisher->id]) }}" class="btn btn-sm btn-danger mt-4 ms-3 ps-4 pe-4 pt-2 pb-2" onclick="return confirm('{{ $publisher->name }} dağıtıcısını silmek istediğinizden emin misiniz?')" title="Sil"><i class="fas fa-trash"></i> Sil</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
