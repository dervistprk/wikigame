@extends('layouts.backend')
@section('title', 'Yönetim Paneli')
@section('content')
    <main>
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
            @if($site_status == 0)
                <div class="alert alert-danger m-2 text-center">
                    <i class="fa fa-exclamation-triangle"></i> Site Bakım Modunda
                </div>
            @endif
            <h1 class="mt-4 d-inline-block">Yönetim Paneli</h1>
            <a href="{{route('home')}}" class="btn btn-sm btn-primary float-end mt-3" title="Anasayfa"
               target="_blank"><i class="fas fa-home" style="margin-top: 3px;"></i> Siteye Git</a>
            <div class="card mb-4 shadow">
                <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#latest-games"
                     role="button" aria-expanded="true" aria-controls="latest-games">
                    <i class="fas fa-gamepad"></i>
                    Son Eklenen Oyunlar <span class="float-end">Toplam {{$games_count}} Oyun</span>
                </div>
                <div class="card-body collapse show" id="latest-games">
                    <div class="table-responsive">
                        @if($games->count() > 0)
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Kapak Resmi</th>
                                    <th>Adı</th>
                                    <th>Kategori</th>
                                    <th>Geliştirici</th>
                                    <th>Dağıtıcı</th>
                                    <th>Platform</th>
                                    <th>Tür</th>
                                    <th>Websitesi</th>
                                    <th>Çıkış Tarihi</th>
                                    <th>Yaş Sınırı</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($games as $game)
                                    <tr @if($game->status == 0) class="alert-danger" @endif>
                                        <td>
                                            <img src="{{ $game->cover_image }}" alt="kapak_resmi"
                                                 title="{{ $game->name }}" class="img-fluid rounded img-thumbnail"
                                                 width="120" height="150">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit-game', $game->id) }}"
                                               class="text-primary text-decoration-none"
                                               title="{{ $game->name }}">{{ $game->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit-category', $game->category->id) }}"
                                               class="text-primary text-decoration-none"
                                               title="{{ $game->category->name }} Kategorisi">{{ $game->category->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit-developer', $game->developer->id) }}"
                                               class="text-primary text-decoration-none"
                                               title="{{ $game->developer->name }} Geliştiricisi">{{ $game->developer->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit-publisher', $game->publisher->id) }}"
                                               class="text-primary text-decoration-none"
                                               title="{{ $game->publisher->name }} Dağıtıcısı">{{ $game->publisher->name }}</a>
                                        </td>
                                        <td>
                                            @php
                                                $game_platforms = $game->platforms->pluck('name' ,'id')->toArray();
                                            @endphp
                                            @foreach($game_platforms as $platform_id => $platform)
                                                <a href="{{ route('admin.edit-platform', $platform_id) }}"
                                                   class="text-primary text-decoration-none">{{ $platform }}</a>
                                                <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $game_genres = $game->genres->pluck('name' ,'id')->toArray();
                                            @endphp
                                            @foreach($game_genres as $genre_id => $genre)
                                                <a href="{{ route('admin.edit-genre', $genre_id) }}"
                                                   class="text-primary text-decoration-none">{{ $genre }}</a>
                                                <br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ $game->details->website }}"
                                               class="text-primary text-decoration-none" target="_blank"
                                               title="{{ $game->name }} Resmi Websitesi">{{ $game->name }}</a>
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($game->details->release_date)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <img src="{{asset('assets/pegi_ratings/pegi_') . $game->details->age_rating . '.png'}}"
                                                 alt="pegi_rating" width="25" height="25"
                                                 title="{{ $game->details->age_rating }} yaş ve üzeri">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-danger text-center">
                                Sistemde kayıtlı oyun bulunamadı.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-4 shadow">
                <div class="card-header font-weight-bold text-secondary" data-toggle="collapse"
                     href="#latest-categories" role="button" aria-expanded="true" aria-controls="latest-categories">
                    <i class="fas fa-bookmark"></i>
                    Son Eklenen Kategoriler <span class="float-end">Toplam {{$categories_count}} Kategori</span>
                </div>
                <div class="card-body collapse show" id="latest-categories">
                    <div class="table-responsive">
                        @if($categories->count() > 0)
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Adı</th>
                                    <th>Açıklama</th>
                                    <th>Oyun Sayısı</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr @if($category->status == 0) class="alert-danger" @endif>
                                        <td>
                                            <a href="{{ route('admin.edit-category', $category->id) }}"
                                               class="text-primary text-decoration-none"
                                               title="{{ $category->name }} Kategorisi">{{ $category->name }}</a>
                                        </td>
                                        <td>
                                            {{ Str::limit(strip_tags(str_replace('&nbsp;', ' ', $category->description)), 250, '...') }}
                                        </td>
                                        <td class="text-center" style="width: 10%">{{ $category->games->count() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-danger text-center">
                                Sistemde kayıtlı kategori bulunamadı.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse"
                             href="#latest-developers" role="button" aria-expanded="true"
                             aria-controls="latest-developers">
                            <i class="fas fa-code"></i>
                            Son Eklenen Geliştiriciler
                            <span class="float-end">Toplam {{$developers_count}} Geliştirici</span>
                        </div>
                        <div class="card-body collapse show" id="latest-developers">
                            <div class="table-responsive">
                                @if($developers->count() > 0)
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Geliştirici Logosu</th>
                                            <th>Adı</th>
                                            <th>Oyun Sayısı</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($developers as $developer)
                                            <tr @if($developer->status == 0) class="alert-danger" @endif>
                                                <td>
                                                    <img src="{{ $developer->image }}" alt="developer_resmi"
                                                         height="100" width="130"
                                                         class="img-fluid rounded img-thumbnail"
                                                         title="{{ $developer->name }}">
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.edit-developer', $developer->id) }}"
                                                       class="text-primary text-decoration-none"
                                                       title="{{ $developer->name }} Geliştiricisi">{{ $developer->name }}</a>
                                                </td>
                                                <td class="text-center">{{ $developer->games->count() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-danger">
                                        Sistemde kayıtlı geliştirici bulunamadı.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse"
                             href="#latest-publishers" role="button" aria-expanded="true"
                             aria-controls="latest-publishers">
                            <i class="fas fa-newspaper"></i>
                            Son Eklenen Dağıtıcılar <span class="float-end">Toplam {{$publishers_count}} Dağıtıcı</span>
                        </div>
                        <div class="card-body collapse show" id="latest-publishers">
                            <div class="table-responsive">
                                @if($publishers->count() > 0)
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Dağıtıcı Logosu</th>
                                            <th>Adı</th>
                                            <th>Oyun Sayısı</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($publishers as $publisher)
                                            <tr @if($publisher->status == 0) class="alert-danger" @endif>
                                                <td>
                                                    <img src="{{ $publisher->image }}" alt="developer_resmi"
                                                         height="100" width="130"
                                                         class="img-fluid rounded img-thumbnail"
                                                         title="{{ $publisher->name }}">
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.edit-publisher', $publisher->id) }}"
                                                       class="text-primary text-decoration-none"
                                                       title="{{ $publisher->name }} Dağıtıcısı">{{ $publisher->name }}</a>
                                                </td>
                                                <td class="text-center">{{ $publisher->games->count() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-danger">
                                        Sistemde kayıtlı dağıtıcı bulunamadı.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse"
                             href="#latest-platforms" role="button" aria-expanded="true"
                             aria-controls="latest-platforms">
                            <i class="fas fa-laptop"></i>
                            Son Eklenen Platformlar
                            <span class="float-end">Toplam {{ $platform_count }} Platform</span>
                        </div>
                        <div class="card-body collapse show" id="latest-platforms">
                            <div class="table-responsive">
                                @if($platforms->count() > 0)
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Adı</th>
                                            <th>Oyun Sayısı</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($platforms as $platform)
                                            <tr @if($platform->status == 0) class="alert-danger" @endif>
                                                <td>
                                                    <a href="{{ route('admin.edit-platform', $platform->id) }}"
                                                       class="text-primary text-decoration-none"
                                                       title="{{ $platform->name }}">{{ $platform->name }}</a>
                                                </td>
                                                <td class="text-center">{{ $platform->games->count() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-danger">
                                        Sistemde kayıtlı platform bulunamadı.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse"
                             href="#latest-genres" role="button" aria-expanded="true" aria-controls="latest-genres">
                            <i class="fas fa-newspaper"></i>
                            Son Eklenen Türler <span class="float-end">Toplam {{$genre_count}} Tür</span>
                        </div>
                        <div class="card-body collapse show" id="latest-genres">
                            <div class="table-responsive">
                                @if($genres->count() > 0)
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Adı</th>
                                            <th>Oyun Sayısı</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($genres as $genre)
                                            <tr @if($genre->status == 0) class="alert-danger" @endif>
                                                <td>
                                                    <a href="{{ route('admin.edit-genre', $genre->id) }}"
                                                       class="text-primary text-decoration-none"
                                                       title="{{ $genre->name }}">{{ $genre->name }}</a>
                                                </td>
                                                <td class="text-center">{{ $genre->games->count() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-danger">
                                        Sistemde kayıtlı tür bulunamadı.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 shadow">
                <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#latest-articles"
                     role="button" aria-expanded="true" aria-controls="latest-articles">
                    <i class="fas fa-book-open"></i>
                    Son Eklenen Makaleler <span class="float-end">Toplam {{$articles_count}} Makale</span>
                </div>
                <div class="card-body collapse show" id="latest-articles">
                    <div class="table-responsive">
                        @if($articles->count() > 0)
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Makale Kapak Resmi</th>
                                    <th>Başlık</th>
                                    <th>Alt Başlık</th>
                                    <th>Okunma Sayısı</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($articles as $article)
                                    <tr @if($article->status == 0) class="alert-danger" @endif>
                                        <td>
                                            <img src="{{ $article->image }}" alt="makale_resmi" height="200" width="300"
                                                 class="img-fluid rounded img-thumbnail" title="{{ $article->title }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit-article', $article->id) }}"
                                               class="text-primary text-decoration-none"
                                               title="{{ $article->title }}">{{ $article->title }}</a>
                                        </td>
                                        <td>{{ Str::limit(strip_tags(str_replace('&nbsp;', ' ', $article->sub_title)), 500, '...') }}</td>
                                        <td class="text-center">{{ $article->hit }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center text-danger">
                                Sistemde kayıtlı makale bulunamadı.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection