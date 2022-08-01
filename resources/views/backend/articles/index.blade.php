@extends('layouts.backend')
@section('title', 'Makaleler')
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
        <a href="{{route('admin.create-article')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Makale Ekle</a>
    </div>
    <div class="card mb-4 m-2">
        <div class="card-header font-weight-bold text-secondary">
            <i class="fas fa-book-open"></i>
            Kayıtlı Makaleler
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                <tr>
                    <th></th>
                    <th>Başlık</th>
                    <th>Alt Başlık</th>
                    <th>Görüntülenme Sayısı</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td><img src="{{ $article->image }}" alt="{{ $article->title }}" title="{{ $article->title }}" width="320" height="180"></td>
                        <td class="font-weight-bold">
                            {{ $article->title }}
                            @if($article->status == 0)
                                <span class="alert-danger d-inline-block p-1 m-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                            @endif
                        </td>
                        <td>{{ $article->sub_title }}  </td>
                        <td class="font-weight-bold">{{ $article->hit }}</td>
                        <td>
                            @if($article->status == 1)
                                <div>
                                    <a target="_blank" href="{{ route('article', [$article->slug]) }}" class="btn btn-sm btn-success" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                                </div>
                            @endif
                            <div class="mt-1">
                                <a href="{{ route('admin.edit-article', [$article->id]) }}" class="btn btn-sm btn-primary" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                            </div>
                            <div class="mt-1">
                                <a href="{{ route('admin.delete-article', [$article->id]) }}" class="btn btn-sm btn-danger p-3" onclick="return confirm('{{ $article->title }} makalesini silmek istediğinizden emin misiniz?')" title="Sil"><i class="fas fa-trash"></i> Sil</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
