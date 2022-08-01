@extends('layouts.backend')
@section('title', 'Kategoriler')
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
        <a href="{{route('admin.create-category')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Kategori Ekle</a>
    </div>
    <div class="card mb-4 m-2">
        <div class="card-header font-weight-bold text-secondary">
            <i class="fas fa-bookmark"></i>
            Kayıtlı Kategoriler
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th>Adı</th>
                    <th>Açıklama</th>
                    <th>Oyun Sayısı</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="font-weight-bold">
                            {{ $category->name }}
                            @if($category->status == 0)
                                <span class="alert-danger d-inline-block p-1 m-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                            @endif
                        </td>
                        <td>{!! trim(strip_tags(Str::limit($category->description, '1000'))) !!}  </td>
                        <td class="font-weight-bold">{{ $category->games_count }}</td>
                        <td>
                            @if($category->status == 1)
                                <div>
                                    <a target="_blank" href="{{ route('category', [$category->slug]) }}" class="btn btn-sm btn-success" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                                </div>
                            @endif
                            <div class="mt-1">
                                <a href="{{ route('admin.edit-category', [$category->id]) }}" class="btn btn-sm btn-primary" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                            </div>
                            <div class="mt-1">
                                <a href="{{ route('admin.delete-category', [$category->id]) }}" class="btn btn-sm btn-danger p-3" onclick="return confirm('{{ $category->name }} kategorisini silmek istediğinizden emin misiniz?')" title="Sil"><i class="fas fa-trash"></i> Sil</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
