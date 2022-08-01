@extends('layouts.backend')
@section('title', 'Yönetim Paneli')
@section('content')
    <main>
        <div class="container-fluid px-4">
            @if(session()->has('message'))
                <div class="alert alert-success m-2 alert-dismissible fade show">
                    {!! session()->get('message') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            @if($site_status == 0)
                    <div class="alert alert-danger m-2 text-center">
                        <i class="fa fa-exclamation-triangle"></i> Site Bakım Modunda
                    </div>
            @endif
            <h1 class="mt-4 d-inline-block">Panel</h1>
            <a href="{{route('home')}}" class="btn btn-sm btn-primary float-end mt-3" title="Anasayfa" target="_blank"><i class="fas fa-home" style="margin-top: 3px;"></i> Siteye Git</a>
            <div class="card mb-4">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-gamepad"></i>
                    Son Eklenen Oyunlar <span class="float-end">Toplam {{$games_count}} Oyun</span>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Kapak Resmi</th>
                            <th>Adı</th>
                            <th>Kategori</th>
                            <th>Geliştirici</th>
                            <th>Dağıtıcı</th>
                            <th>Websitesi</th>
                            <th>Çıkış Tarihi</th>
                            <th>Yaş Sınırı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($games as $game)
                            <tr>
                                <td>
                                    <img src="{{ $game->cover_image }}" alt="kapak_resmi" title="{{ $game->name }}" width="75" height="100">
                                </td>
                                <td>
                                    <a href="{{ route('admin.edit-game', $game->id) }}" class="text-primary text-decoration-none" title="{{ $game->name }}">{{ $game->name }}</a>
                                    @if($game->status == 0)
                                        <span class="d-inline-block alert-danger p-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.edit-category', $game->category->id) }}" class="text-primary text-decoration-none" title="{{ $game->category->name }} Kategorisi">{{ $game->category->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.edit-developer', $game->developer->id) }}" class="text-primary text-decoration-none" title="{{ $game->developer->name }} Geliştiricisi">{{ $game->developer->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.edit-publisher', $game->publisher->id) }}" class="text-primary text-decoration-none" title="{{ $game->publisher->name }} Dağıtıcısı">{{ $game->publisher->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ $game->details->website }}" class="text-primary text-decoration-none" target="_blank" title="{{ $game->name }} Resmi Websitesi">{{ $game->name }}</a>
                                </td>
                                <td>{{ Carbon\Carbon::parse($game->details->release_date)->format('d/m/Y') }}</td>
                                <td>&nbsp;&nbsp;<img src="{{asset('assets/pegi_ratings/pegi_') . $game->details->age_rating . '.png'}}" alt="pegi_rating" width="25" height="25" title="{{ $game->details->age_rating }} yaş ve üzeri"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-bookmark"></i>
                    Son Eklenen Kategoriler <span class="float-end">Toplam {{$categories_count}} Kategori</span>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Adı</th>
                            <th>Oyun Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td style="width: 90%">
                                    <a href="{{ route('admin.edit-category', $category->id) }}" class="text-primary text-decoration-none" title="{{ $category->name }} Kategorisi">{{ $category->name }}</a>
                                    @if($category->status == 0)
                                        <span class="alert-danger p-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                                    @endif
                                </td>
                                <td>{{ $category->games_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-calculator"></i>
                    Son Eklenen Geliştiriciler <span class="float-end">Toplam {{$developers_count}} Geliştirici</span>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Adı</th>
                            <th>Oyun Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($developers as $developer)
                            <tr>
                                <td>
                                    <img src="{{ $developer->image }}" alt="developer_resmi" height="75" width="100" class="m-2" title="{{ $developer->name }}">
                                </td>
                                <td style="width: 70%">
                                    <a href="{{ route('admin.edit-developer', $developer->id) }}" class="text-primary text-decoration-none" title="{{ $developer->name }} Geliştiricisi">{{ $developer->name }}</a>
                                    @if($developer->status == 0)
                                        <span class="alert-danger p-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                                    @endif
                                </td>
                                <td>{{ $developer->games_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header font-weight-bold text-secondary">
                    <i class="fas fa-newspaper"></i>
                    Son Eklenen Dağıtıcılar <span class="float-end">Toplam {{$publishers_count}} Dağıtıcı</span>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Adı</th>
                            <th>Oyun Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($publishers as $publisher)
                            <tr>
                                <td>
                                    <img src="{{ $publisher->image }}" alt="developer_resmi" height="75" width="100" class="m-2" title="{{ $publisher->name }}">
                                </td>
                                <td style="width: 70%">
                                    <a href="{{ route('admin.edit-publisher', $publisher->id) }}" class="text-primary text-decoration-none" title="{{ $publisher->name }} Dağıtıcısı">{{ $publisher->name }}</a>
                                    @if($publisher->status == 0)
                                        <span class="alert-danger p-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                                    @endif
                                </td>
                                <td>{{ $publisher->games_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                <div class="card mb-4">
                    <div class="card-header font-weight-bold text-secondary">
                        <i class="fas fa-book-open"></i>
                        Son Eklenen Makaleler <span class="float-end">Toplam {{$articles_count}} Makale</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Başlık</th>
                                <th>Alt başlık</th>
                                <th>Okunma Sayısı</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>
                                        <img src="{{ $article->image }}" alt="makale_resmi" height="150" width="200" class="m-2" title="{{ $article->title }}">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-article', $article->id) }}" class="text-primary text-decoration-none" title="{{ $article->title }}">{{ $article->title }}</a>
                                        @if($article->status == 0)
                                            <span class="alert-danger p-1"><i class="fas fa-times" style="color: red"></i> Pasif</span>
                                        @endif
                                    </td>
                                    <td>{{ $article->sub_title }}</td>
                                    <td>{{ $article->hit }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

        </div>
    </main>
@endsection
