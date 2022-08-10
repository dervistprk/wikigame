@extends('layouts.backend')
@section('title', 'Dağıtıcılar')
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
            <a href="{{route('admin.create-publisher')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Dağıtıcı Ekle</a>
        </div>
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-newspaper"></i>
                Kayıtlı Dağıtıcılar
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table-responsive">
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
                        @php
                            $target = $publisher;
                            $route  = 'publisher';
                        @endphp
                        <tr class="@if($publisher->status == 0) alert-danger @endif">
                            <td>
                                <img src="{{ $publisher->image }}" alt="geliştirici resmi" class="img-fluid img-thumbnail" title="{{ $publisher->name }}" width="200" height="150">
                            </td>
                            <td class="font-weight-bold">
                                {{ $publisher->name }}
                                @if($publisher->status == 0)
                                    <span class="text-danger d-inline-block p-1 m-1"><i class="fas fa-times"></i> Pasif</span>
                                @endif
                            </td>
                            <td class="font-weight-bold">{{ $publisher->games_count }}</td>
                            <td>
                                <div class="mt-5">
                                    @if($publisher->status == 1)
                                        <a target="_blank" href="{{ route('publisher', [$publisher->slug]) }}" class="btn btn-success" title="Görüntüle"><i class="fas fa-eye"></i> Görüntüle</a>
                                    @endif
                                    <a href="{{ route('admin.edit-publisher', [$publisher->id]) }}" class="btn btn-primary" title="Düzenle"><i class="fas fa-pen"></i> Düzenle</a>
                                    <a href="#" data-id="{{$publisher->id}}" class="btn btn-danger delete" data-toggle="modal" data-target="#delete{{$target->slug}}Modal_{{$target->id}}"><i class="fas fa-trash"></i> Sil</a>
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
