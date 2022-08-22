@extends('layouts.backend')
@section('title', 'Oyun Ekle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" method="post" novalidate action="{{route('admin.create-game-post')}}" enctype="multipart/form-data">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger text-center alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @csrf
            <div class="card shadow">
                <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#game-information" role="button" aria-expanded="true" aria-controls="game-information">
                    <i class="fas fa-gamepad"></i>
                    Oyun Ekle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body collapse show" id="game-information">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Adı*</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Oyun Adını Giriniz" value="{{ old('name') }}" required>
                            <div class="invalid-feedback">
                                Lütfen oyun adı girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="text-primary font-weight-bold">Alt Başlık*</label>
                            <input type="text" class="form-control" id="subtitle" name="sub_title" placeholder="Oyun Altbaşlığını Giriniz" value="{{ old('sub_title') }}" required>
                            <div class="invalid-feedback">
                                Lütfen oyun altbaşlığı girin.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="category" class="text-primary col-form-label font-weight-bold">Kategori*</label>
                                    <select class="form-select" id="category" name="category_id" required>
                                        <option value="" hidden>Kategori Seçiniz</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected="selected" @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun kategorisi seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group"> <!--TODO: age_rating, platform ve genre için ayrı tablolar oluşturup modelleri bağla ve ilgili her yeri düzenle -->
                                    <label for="age_rating" class="text-primary col-form-label font-weight-bold">Yaş Sınırı*</label>
                                    <select class="form-select" id="age_rating" name="age_rating" required>
                                        <option value="" hidden>Yaş Sınırı Seçiniz</option>
                                        @if(old('age_rating') == 3)
                                            <option value="3" selected="selected">3</option>
                                            <option value="7">7</option>
                                            <option value="12">12</option>
                                            <option value="16">16</option>
                                            <option value="18">18</option>
                                        @elseif(old('age_rating') == 7)
                                            <option value="3">3</option>
                                            <option value="7" selected="selected">7</option>
                                            <option value="12">12</option>
                                            <option value="16">16</option>
                                            <option value="18">18</option>
                                        @elseif(old('age_rating') == 12)
                                            <option value="3">3</option>
                                            <option value="7">7</option>
                                            <option value="12" selected="selected">12</option>
                                            <option value="16">16</option>
                                            <option value="18">18</option>
                                        @elseif(old('age_rating') == 16)
                                            <option value="3">3</option>
                                            <option value="7">7</option>
                                            <option value="12">12</option>
                                            <option value="16" selected="selected">16</option>
                                            <option value="18">18</option>
                                        @elseif(old('age_rating') == 18)
                                            <option value="3">3</option>
                                            <option value="7">7</option>
                                            <option value="12">12</option>
                                            <option value="16">16</option>
                                            <option value="18" selected="selected">18</option>
                                        @else
                                            <option value="3">3</option>
                                            <option value="7">7</option>
                                            <option value="12">12</option>
                                            <option value="16">16</option>
                                            <option value="18">18</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun yaş sınırı seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="status" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="" hidden>Durum Seçiniz</option>
                                        @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}" @if(old('status') == $key) selected="selected" @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun kategorisi seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="developer" class="text-primary col-form-label font-weight-bold">Geliştirici*</label>
                                    <select class="form-select" id="developer" name="developer_id" required>
                                        <option value="" hidden>Geliştirici Seçiniz</option>
                                        @foreach($developers as $developer)
                                            <option value="{{ $developer->id }}" @if (old('developer_id') == $developer->id) selected="selected" @endif>{{ $developer->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun geliştiricisi seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="publisher" class="text-primary col-form-label font-weight-bold">Dağıtıcı*</label>
                                    <select class="form-select" id="publisher" name="publisher_id" required>
                                        <option value="" hidden>Dağıtıcı Seçiniz</option>
                                        @foreach($publishers as $publisher)
                                            <option value="{{ $publisher->id }}" @if (old('publisher_id') == $publisher->id) selected="selected" @endif>{{ $publisher->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun dağıtıcısı seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="platform" class="text-primary col-form-label font-weight-bold">Platform*</label>
                                    <select multiple class="form-select" id="platform" name="platform[]" size="7" required>
                                        <option value="PC" @if(old('platform')) @if(in_array('PC', old('platform'))) selected="selected"@endif @endif>PC</option>
                                        <option value="MAC" @if(old('platform')) @if(in_array('MAC', old('platform'))) selected="selected"@endif @endif>MAC</option>
                                        <option value="Linux" @if(old('platform')) @if(in_array('Linux', old('platform'))) selected="selected"@endif @endif>Linux</option>
                                        <option value="PS1" @if(old('platform')) @if(in_array('PS1', old('platform'))) selected="selected"@endif @endif>PS1</option>
                                        <option value="PS2" @if(old('platform')) @if(in_array('PS2', old('platform'))) selected="selected"@endif @endif>PS2</option>
                                        <option value="PS3" @if(old('platform')) @if(in_array('PS3', old('platform'))) selected="selected"@endif @endif>PS3</option>
                                        <option value="PS4" @if(old('platform')) @if(in_array('PS4', old('platform'))) selected="selected"@endif @endif>PS4</option>
                                        <option value="PS5" @if(old('platform')) @if(in_array('PS5', old('platform'))) selected="selected"@endif @endif>PS5</option>
                                        <option value="XBox 360" @if(old('platform')) @if(in_array('XBox 360', old('platform'))) selected="selected"@endif @endif>XBox 360</option>
                                        <option value="XBox One" @if(old('platform')) @if(in_array('XBox One', old('platform'))) selected="selected"@endif @endif>XBox One</option>
                                        <option value="XBox Series X/S" @if(old('platform')) @if(in_array('XBox Series X/S', old('platform'))) selected="selected"@endif @endif>XBox Series X/S</option>
                                        <option value="Nintendo Switch" @if(old('platform')) @if(in_array('Nintendo Switch', old('platform'))) selected="selected"@endif @endif>Nintendo Switch</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun platformu seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="genre" class="text-primary col-form-label font-weight-bold">Tür*</label>
                                    <select multiple class="form-select" id="genre" name="genre[]" size="7" required>
                                        <option value="Aksiyon" @if(old('genre')) @if(in_array('Aksiyon', old('genre'))) selected="selected"@endif @endif>Aksiyon</option>
                                        <option value="Battle Royale" @if(old('genre')) @if(in_array('Battle Royale', old('genre'))) selected="selected"@endif @endif>Battle Royale</option>
                                        <option value="Bulmaca" @if(old('genre')) @if(in_array('Bulmaca', old('genre'))) selected="selected"@endif @endif>Bulmaca</option>
                                        <option value="Çevrimiçi Rol Yapma" @if(old('genre')) @if(in_array('Çevrimiçi Rol Yapma', old('genre'))) selected="selected"@endif @endif>Çevrimiçi Rol Yapma</option>
                                        <option value="Dövüş" @if(old('genre')) @if(in_array('Dövüş', old('genre'))) selected="selected"@endif @endif>Dövüş</option>
                                        <option value="Gerilim" @if(old('genre')) @if(in_array('Gerilim', old('genre'))) selected="selected"@endif @endif>Gerilim</option>
                                        <option value="Hayatta Kalma" @if(old('genre')) @if(in_array('Hayatta Kalma', old('genre'))) selected="selected"@endif @endif>Hayatta Kalma</option>
                                        <option value="Korku" @if(old('genre')) @if(in_array('Korku', old('genre'))) selected="selected"@endif @endif>Korku</option>
                                        <option value="Macera" @if(old('genre')) @if(in_array('Macera', old('genre'))) selected="selected"@endif @endif>Macera</option>
                                        <option value="MOBA" @if(old('genre')) @if(in_array('MOBA', old('genre'))) selected="selected"@endif @endif>MOBA</option>
                                        <option value="Platform" @if(old('genre')) @if(in_array('Platform', old('genre'))) selected="selected"@endif @endif>Platform</option>
                                        <option value="Rol Yapma" @if(old('genre')) @if(in_array('Rol Yapma', old('genre'))) selected="selected"@endif @endif>Rol Yapma</option>
                                        <option value="Savaş" @if(old('genre')) @if(in_array('Savaş', old('genre'))) selected="selected"@endif @endif>Savaş</option>
                                        <option value="Simülasyon" @if(old('genre')) @if(in_array('Simülasyon', old('genre'))) selected="selected"@endif @endif>Simülasyon</option>
                                        <option value="Spor" @if(old('genre')) @if(in_array('Spor', old('genre'))) selected="selected"@endif @endif>Spor</option>
                                        <option value="Strateji" @if(old('genre')) @if(in_array('Strateji', old('genre'))) selected="selected"@endif @endif>Strateji</option>
                                        <option value="Yarış" @if(old('genre')) @if(in_array('Yarış', old('genre'))) selected="selected"@endif @endif>Yarış</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun türü seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="release_date" class="text-primary col-form-label font-weight-bold">Çıkış Tarihi*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" class="form-control date-picker" id="release_date" name="release_date" placeholder="Oyun Çıkış Tarihini Seçin" value="{{ old('release_date') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen oyun çıkış tarihi seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="website" class="text-primary col-form-label font-weight-bold">Resmi İnternet Sitesi*</label>
                                    <input type="text" class="form-control" id="website" name="website" placeholder="Oyun Website Adresini Giriniz" value="{{ old('website') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen oyun website adresini girin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text-primary form-label font-weight-bold">Oyun Açıklaması*</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Oyun Açıklaması Giriniz" required>{{ old('description') }}</textarea>
                            <div class="invalid-feedback">
                                Lütfen oyun açıklaması girin.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mt-2">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#sys-req-min" role="button" aria-expanded="true" aria-controls="sys-req-min">
                            Minimum Sistem Gereksinimleri*
                        </div>
                        <div class="card-body collapse show" id="sys-req-min">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cpu_min" class="text-primary form-label font-weight-bold">İşlemci</label>
                                    <input type="text" class="form-control" id="cpu_min" name="cpu_min" placeholder="İşlemci Giriniz" value="{{ old('cpu_min') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işlemci girin.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gpu_min" class="text-primary form-label font-weight-bold">Ekran Kartı</label>
                                    <input type="text" class="form-control" id="gpu_min" name="gpu_min" placeholder="Ekran Kartı Giriniz" value="{{ old('gpu_min') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen ekran kartı girin.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="ram_min" class="text-primary col-form-label font-weight-bold">Bellek</label>
                                            <input type="number" class="form-control" id="ram_min" name="ram_min" placeholder="Bellek Giriniz" value="{{ old('ram_min') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen bellek girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ram_min_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="ram_min_unit" name="ram_min_unit" required>
                                                <option value="" hidden>Birim Seçiniz</option>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if(old('ram_min_unit') == $value) selected="selected" @endif>{{ $req_unit }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Lütfen birim seçin.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="storage_min" class="text-primary col-form-label font-weight-bold">Depolama Alanı</label>
                                            <input type="number" class="form-control" id="storage_min" name="storage_min" placeholder="Depolama Alanı Giriniz" value="{{ old('storage_min') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen depolama alanı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="storage_min_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="storage_min_unit" name="storage_min_unit" required>
                                                <option value="" hidden>Birim Seçiniz</option>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if(old('storage_min_unit') == $value) selected="selected" @endif>{{ $req_unit }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Lütfen birim seçin.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="os_min" class="text-primary form-label font-weight-bold">İşletim Sistemi</label>
                                    <input type="text" class="form-control" id="os_min" name="os_min" placeholder="İşletim Sistemi Giriniz" value="{{ old('os_min') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işletim sistemi girin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mt-2">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#sys-req-rec" role="button" aria-expanded="true" aria-controls="sys-req-rec">
                            Önerilen Sistem Gereksinimleri*
                        </div>
                        <div class="card-body collapse show" id="sys-req-rec">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cpu_rec" class="text-primary form-label font-weight-bold">İşlemci</label>
                                    <input type="text" class="form-control" id="cpu_rec" name="cpu_rec" placeholder="İşlemci Giriniz" value="{{ old('cpu_rec') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işlemci girin.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gpu_rec" class="text-primary form-label font-weight-bold">Ekran Kartı</label>
                                    <input type="text" class="form-control" id="gpu_rec" name="gpu_rec" placeholder="Ekran Kartı Giriniz" value="{{ old('gpu_rec') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen ekran kartı girin.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="ram_rec" class="text-primary col-form-label font-weight-bold">Bellek</label>
                                            <input type="number" class="form-control" id="ram_rec" name="ram_rec" placeholder="Bellek Giriniz" value="{{ old('ram_rec') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen bellek girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ram_rec_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="ram_rec_unit" name="ram_rec_unit" required>
                                                <option value="" hidden>Birim Seçiniz</option>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if(old('ram_rec_unit') == $value) selected="selected" @endif>{{ $req_unit }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Lütfen birim seçin.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="storage_rec" class="text-primary col-form-label font-weight-bold">Depolama Alanı</label>
                                            <input type="number" class="form-control" id="storage_rec" name="storage_rec" placeholder="Depolama Alanı Giriniz" value="{{ old('storage_rec') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen depolama alanı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="storage_rec_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="storage_rec_unit" name="storage_rec_unit" required>
                                                <option value="" selected="selected" hidden>Birim Seçiniz</option>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if(old('storage_rec_unit') == $value) selected="selected" @endif>{{ $req_unit }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Lütfen birim seçin.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="os_rec" class="text-primary form-label font-weight-bold">İşletim Sistemi</label>
                                    <input type="text" class="form-control" id="os_rec" name="os_rec" placeholder="İşletim Sistemi Giriniz" value="{{ old('os_rec') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işletim sistemi girin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mt-2">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#game-images" role="button" aria-expanded="true" aria-controls="game-images">
                            Oyun Resimleri
                        </div>
                        <div class="card-body collapse show" id="game-images">
                            <div class="col-sm">
                                <div class="form-group row">
                                    <label for="cover_image" class="text-primary form-label font-weight-bold">Kapak Resmi*</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control-file btn btn-primary btn-sm btn-block" required>
                                    <div class="invalid-feedback">
                                        Lütfen oyun kapak resmi seçin.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="image1" class="text-primary form-label font-weight-bold">Resim1*</label>
                                    <input type="file" name="image1" id="image1" class="form-control-file btn btn-primary btn-sm btn-block" required>
                                    <div class="invalid-feedback">
                                        Lütfen oyun resmi seçin.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mt-2 align-top">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#game-videos" role="button" aria-expanded="true" aria-controls="game-videos">
                            Oyun Videoları
                        </div>
                        <div class="card-body collapse show" id="game-videos">
                            <div class="form-group col-sm-3">
                                <label for="video-count" class="text-primary form-label font-weight-bold">Video Sayısı</label>
                                <select class="form-select video-count" id="video-count" name="video_count">
                                    @for($i = 1; $i <= config('game_config.video_count'); $i++)
                                        <option value="{{ $i }}" @if(old('video_count' == $i)) selected="selected" @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm">
                                <a href="https://support.google.com/youtube/answer/171780?hl=tr" class="text-info text-decoration-none d-inline-block mb-1" target="_blank">Youtube Video Ekleme Yardım İçin Tıklayınız</a>
                                <div class="form-group">
                                    <label for="video1" class="text-primary form-label font-weight-bold">Video1*</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">https://www.youtube.com/embed/</div>
                                        </div>
                                        <input type="text" class="form-control" id="video1" name="url[]" placeholder="Video Linkini Giriniz" required/>
                                        <input type="hidden" name="video_hash[]" value="{{ \Str::random(20) }}"/>
                                        <div class="invalid-feedback">
                                            Lütfen geçerli bir video URL adresi girin.
                                        </div>
                                    </div>
                                </div>
                                <div class="other-videos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2 text-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.games')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $('.video-count').change(function() {
          $('.other-videos').html('');
          var video_count = $(this).val();

          for (var i = 1; i < video_count; i++) {
             $('.other-videos').append('<div class="form-group"><label for="video' + (i + 1) + '" class="text-primary form-label font-weight-bold">Video' + (i + 1) + '</label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">https://www.youtube.com/embed/</div></div><input type="text" class="form-control" id="video' + (i + 1) + '" name="url[]" placeholder="Video Linkini Giriniz" required/><input type="hidden" name="video_hash[]" value="' + strRandom(20) + '"/></div></div>');
          }
       });

       function strRandom(length) {
          var result           = '';
          var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
          var charactersLength = characters.length;
          for (var i = 0; i < length; i++) {
             result += characters.charAt(Math.floor(Math.random() * charactersLength));
          }
          return result;
       }
    </script>
@endsection