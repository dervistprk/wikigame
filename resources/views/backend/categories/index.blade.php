@extends('layouts.backend')
@section('title', 'Kategoriler')
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
            <a href="{{route('admin.create-category')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus"></i> Kategori Ekle</a>
        </div>
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-bookmark"></i>
                Kayıtlı Kategoriler
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table-responsive">
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
                        @php
                            $target = $category;
                            $route  = 'category';
                        @endphp
                        <tr class="@if($category->status == 0) alert-danger @endif">
                            <td class="font-weight-bold">
                                {{ $category->name }}
                                @if($category->status == 0)
                                    <span class="d-inline-block p-1 m-1 text-danger"><i class="fas fa-times"></i> Pasif</span>
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
                                    <a href="#" data-id="{{$category->id}}" class="btn btn-danger delete" data-toggle="modal" data-target="#delete{{$target->slug}}Modal_{{$target->id}}"><i class="fas fa-trash"></i> Sil</a>
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