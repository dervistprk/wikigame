@extends('layouts.backend')
@section('title', 'Oyun Düzenle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" novalidate method="post" action="{{route('admin.edit-game-post', [$game->id])}}" enctype="multipart/form-data">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-5">
                        <div class="alert alert-danger alert-dismissible fade show">
                            @foreach($errors->all() as $error)
                                <li>{!! $error !!}</li>
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
                    Oyun Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
                </div>
                <div class="card-body collapse show" id="game-information">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="name" class="text-primary form-label font-weight-bold">Adı*</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Oyun Adını Giriniz" value="{{ $game->name }}" required>
                            <div class="invalid-feedback">
                                Lütfen bir oyun adı girin.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="text-primary form-label font-weight-bold">Alt Başlık*</label>
                            <input type="text" class="form-control" id="subtitle" name="sub_title" placeholder="Oyun Altbaşlığını Giriniz" value="{{ $game->sub_title }}" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="category" class="text-primary col-form-label font-weight-bold">Kategori*</label>
                                    <select class="form-select" id="category" name="category_id" required>
                                        @foreach($categories as $category)
                                            <option @if($game->category_id == $category->id) selected="selected" @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir kategori seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="age_rating" class="text-primary col-form-label font-weight-bold">Yaş Sınırı*</label>
                                    <select class="form-select" id="age_rating" name="age_rating">
                                        <option @if($game->details->age_rating == 3) selected="selected" @endif value="3">3</option>
                                        <option @if($game->details->age_rating == 7) selected="selected" @endif value="7">7</option>
                                        <option @if($game->details->age_rating == 12) selected="selected" @endif value="12">12</option>
                                        <option @if($game->details->age_rating == 16) selected="selected" @endif value="16">16</option>
                                        <option @if($game->details->age_rating == 18) selected="selected" @endif value="18">18</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir yaş sınırı seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="status" class="text-primary col-form-label font-weight-bold">Durum*</label>
                                    <select class="form-select" id="status" name="status">
                                        <option @if($game->status == 0) selected="selected" @endif value="0">Pasif</option>
                                        <option @if($game->status == 1) selected="selected" @endif value="1">Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen durum seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="developer" class="text-primary col-form-label font-weight-bold">Geliştirici*</label>
                                    <select class="form-select" id="developer" name="developer_id" required>
                                        @foreach($developers as $developer)
                                            <option @if($game->developer_id == $developer->id) selected="selected" @endif value="{{ $developer->id }}">{{ $developer->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir geliştirici seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="publisher" class="text-primary col-form-label font-weight-bold">Dağıtıcı*</label>
                                    <select class="form-select" id="publisher" name="publisher_id" required>
                                        @foreach($publishers as $publisher)
                                            <option @if($game->publisher_id == $publisher->id) selected="selected" @endif value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir dağıtıcı seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="platform" class="text-primary col-form-label font-weight-bold">Platform*</label>
                                    <select multiple class="form-select" id="platform" name="platform[]" size="7">
                                        <option value="PC" @if(str_contains($game->details->platform, 'PC')) selected="selected"@endif>PC</option>
                                        <option value="PC" @if(str_contains($game->details->platform, 'MAC')) selected="selected"@endif>MAC</option>
                                        <option value="PC" @if(str_contains($game->details->platform, 'Linux')) selected="selected"@endif>Linux</option>
                                        <option value="PS1" @if(str_contains($game->details->platform, 'PS1')) selected="selected"@endif>PS1</option>
                                        <option value="PS2" @if(str_contains($game->details->platform, 'PS2')) selected="selected"@endif>PS2</option>
                                        <option value="PS3" @if(str_contains($game->details->platform, 'PS3')) selected="selected"@endif>PS3</option>
                                        <option value="PS4" @if(str_contains($game->details->platform, 'PS4')) selected="selected"@endif>PS4</option>
                                        <option value="PS5" @if(str_contains($game->details->platform, 'PS5')) selected="selected"@endif>PS5</option>
                                        <option value="XBox 360" @if(str_contains($game->details->platform, 'XBox 360')) selected="selected"@endif>XBox 360</option>
                                        <option value="XBox One" @if(str_contains($game->details->platform, 'XBox One')) selected="selected"@endif>XBox One</option>
                                        <option value="XBox Series X/S" @if(str_contains($game->details->platform, 'XBox Series X/S')) selected="selected"@endif>XBox Series X/S</option>
                                        <option value="Nintendo Switch" @if(str_contains($game->details->platform, 'Nintendo Switch')) selected="selected"@endif>Nintendo Switch</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir platform seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="genre" class="text-primary col-form-label font-weight-bold">Tür*</label>
                                    <select multiple class="form-select" id="genre" name="genre[]" size="7">
                                        <option value="Aksiyon" @if(str_contains($game->details->genre, 'Aksiyon')) selected="selected"@endif>Aksiyon</option>
                                        <option value="Battle Royale" @if(str_contains($game->details->genre, 'Battle Royale')) selected="selected"@endif>Battle Royale</option>
                                        <option value="Bulmaca" @if(str_contains($game->details->genre, 'Bulmaca')) selected="selected"@endif>Bulmaca</option>
                                        <option value="Çevrimiçi Rol Yapma" @if(str_contains($game->details->genre, 'Çevrimiçi Rol Yapma')) selected="selected"@endif>Çevrimiçi Rol Yapma</option>
                                        <option value="Dövüş" @if(str_contains($game->details->genre, 'Dövüş')) selected="selected"@endif>Dövüş</option>
                                        <option value="Gerilim" @if(str_contains($game->details->genre, 'Gerilim')) selected="selected"@endif>Gerilim</option>
                                        <option value="Hayatta Kalma" @if(str_contains($game->details->genre, 'Hayatta Kalma')) selected="selected"@endif>Hayatta Kalma</option>
                                        <option value="Korku" @if(str_contains($game->details->genre, 'Korku')) selected="selected"@endif>Korku</option>
                                        <option value="Macera" @if(str_contains($game->details->genre, 'Macera')) selected="selected"@endif>Macera</option>
                                        <option value="MOBA" @if(str_contains($game->details->genre, 'MOBA')) selected="selected"@endif>MOBA</option>
                                        <option value="Platform" @if(str_contains($game->details->genre, 'Platform')) selected="selected"@endif>Platform</option>
                                        <option value="Rol Yapma" @if(str_contains($game->details->genre, 'Rol Yapma')) selected="selected"@endif>Rol Yapma</option>
                                        <option value="Savaş" @if(str_contains($game->details->genre, 'Savaş')) selected="selected"@endif>Savaş</option>
                                        <option value="Simülasyon" @if(str_contains($game->details->genre, 'Simülasyon')) selected="selected"@endif>Simülasyon</option>
                                        <option value="Spor" @if(str_contains($game->details->genre, 'Spor')) selected="selected"@endif>Spor</option>
                                        <option value="Strateji" @if(str_contains($game->details->genre, 'Strateji')) selected="selected"@endif>Strateji</option>
                                        <option value="Strateji" @if(str_contains($game->details->genre, 'Yarış')) selected="selected"@endif>Yarış</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir tür seçin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="release_date" class="text-primary col-form-label font-weight-bold">Çıkış Tarihi*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" class="form-control date-picker" id="release_date" name="release_date" value="{{ $game->details->release_date }}" required>
                                        <div class="invalid-feedback">
                                            Lütfen çıkış tarihi girin.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="website" class="text-primary col-form-label font-weight-bold">Resmi İnternet Sitesi*</label>
                                    <input type="text" class="form-control" id="website" name="website" value="{{ $game->details->website }}">
                                    <div class="invalid-feedback">
                                        Lütfen website adresi girin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text-primary form-label font-weight-bold">Oyun Açıklaması*</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Oyun Açıklaması Giriniz" required>{{ $game->description }}</textarea>
                            <div class="invalid-feedback">
                                Lütfen açıklama girin.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mt-2 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#sys-req-min" role="button" aria-expanded="true" aria-controls="sys-req-min">
                            Minimum Sistem Gereksinimleri*
                        </div>
                        <div class="card-body collapse show" id="sys-req-min">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cpu_min" class="text-primary form-label font-weight-bold">İşlemci</label>
                                    <input type="text" class="form-control" id="cpu_min" name="cpu_min" placeholder="İşlemci Giriniz" value="{{ $game->systemReqMin->cpu_min }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işlemci girin.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gpu_min" class="text-primary form-label font-weight-bold">Ekran Kartı</label>
                                    <input type="text" class="form-control" id="gpu_min" name="gpu_min" placeholder="Ekran Kartı Giriniz" value="{{ $game->systemReqMin->gpu_min }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen ekran kartı girin.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="ram_min" class="text-primary col-form-label font-weight-bold">Bellek</label>
                                            <input type="number" class="form-control" id="ram_min" name="ram_min" placeholder="Bellek Giriniz" value="{{ $game->systemReqMin->ram_min }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen bellek miktarı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ram_min_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="ram_min_unit" name="ram_min_unit" required>
                                                <option value="" hidden>Birim Seçiniz</option>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if($game->systemReqMin->ram_min_unit == $value) selected="selected" @endif>{{ $req_unit }}</option>
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
                                            <input type="number" class="form-control" id="storage_min" name="storage_min" placeholder="Depolama Alanı Giriniz" value="{{ $game->systemReqMin->storage_min }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen depolama alanı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="storage_min_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="storage_min_unit" name="storage_min_unit" required>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if($game->systemReqMin->storage_min_unit == $value) selected="selected" @endif>{{ $req_unit }}</option>
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
                                    <input type="text" class="form-control" id="os_min" name="os_min" placeholder="İşletim Sistemi Giriniz" value="{{ $game->systemReqMin->os_min }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işletim sistemi girin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mt-2 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#sys-req-rec" role="button" aria-expanded="true" aria-controls="sys-req-rec">
                            Önerilen Sistem Gereksinimleri*
                        </div>
                        <div class="card-body collapse show" id="sys-req-rec">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cpu_rec" class="text-primary form-label font-weight-bold">İşlemci</label>
                                    <input type="text" class="form-control" id="cpu_rec" name="cpu_rec" placeholder="İşlemci Giriniz" value="{{ $game->systemReqRec->cpu_rec }}" required/>
                                    <div class="invalid-feedback">
                                        Lütfen işlemci girin.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gpu_rec" class="text-primary form-label font-weight-bold">Ekran Kartı</label>
                                    <input type="text" class="form-control" id="gpu_rec" name="gpu_rec" placeholder="Ekran Kartı Giriniz" value="{{ $game->systemReqRec->gpu_rec }}" required/>
                                    <div class="invalid-feedback">
                                        Lütfen ekran kartı girin.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="ram_rec" class="text-primary col-form-label font-weight-bold">Bellek</label>
                                            <input type="number" class="form-control" id="ram_rec" name="ram_rec" placeholder="Bellek Giriniz" value="{{ $game->systemReqRec->ram_rec }}" required/>
                                            <div class="invalid-feedback">
                                                Lütfen bellek girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ram_rec_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="ram_rec_unit" name="ram_rec_unit" required>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if($game->systemReqRec->ram_rec_unit == $value) selected="selected" @endif>{{ $req_unit }}</option>
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
                                            <input type="number" class="form-control" id="storage_rec" name="storage_rec" placeholder="Depolama Alanı Giriniz" value="{{ $game->systemReqRec->storage_rec }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen depolama alanı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="storage_rec_unit" class="text-primary col-form-label font-weight-bold">Birim</label>
                                            <select class="form-select" id="storage_rec_unit" name="storage_rec_unit" required>
                                                @foreach(config('game_config.sys_req_units') as $value => $req_unit)
                                                    <option value="{{ $value }}" @if($game->systemReqRec->storage_rec_unit == $value) selected="selected" @endif>{{ $req_unit }}</option>
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
                                    <input type="text" class="form-control" id="os_rec" name="os_rec" placeholder="İşletim Sistemi Giriniz" value="{{ $game->systemReqRec->os_rec }}" required>
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
                    <div class="card mt-2 shadow">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#game-images" role="button" aria-expanded="true" aria-controls="game-images">
                            Oyun Resimleri
                        </div>
                        <div class="card-body collapse show" id="game-images">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cover_image" class="text-primary form-label font-weight-bold">Kapak Resmi*</label>
                                    <div class="row col">
                                        <input type="file" name="cover_image" id="cover_image" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    <img src="{{ $game->cover_image }}" alt="{{ $game->name }} Kapak Resmi" title="{{ $game->name }} Kapak Resmi" class="mt-1 rounded img-fluid img-thumbnail" width="175" height="225">
                                </div>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim1*</label>
                                    <div class="row col">
                                        <input type="file" name="image1" id="image1" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    <img src="{{ $game->image1 }}" alt="{{ $game->name }} Resim1" title="{{ $game->name }} Resim1" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim2</label>
                                    <div class="row col">
                                        <input type="file" name="image2" id="image2" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    @if(isset($game->image2))
                                        <img src="{{ $game->image2 }}" alt="{{ $game->name }} Resim2" title="{{ $game->name }} Resim2" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    @endif
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim3</label>
                                    <div class="row col">
                                        <input type="file" name="image3" id="image3" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    @if(isset($game->image3))
                                        <img src="{{ $game->image3 }}" alt="{{ $game->name }} Resim3" title="{{ $game->name }} Resim3" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    @endif
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim4</label>
                                    <div class="row col">
                                        <input type="file" name="image4" id="image4" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    @if(isset($game->image4))
                                        <img src="{{ $game->image4 }}" alt="{{ $game->name }} Resim4" title="{{ $game->name }} Resim4" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    @endif
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim5</label>
                                    <div class="row col">
                                        <input type="file" name="image5" id="image5" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    @if(isset($game->image5))
                                        <img src="{{ $game->image5 }}" alt="{{ $game->name }} Resim5" title="{{ $game->name }} Resim5" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    @endif
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim6</label>
                                    <div class="row col">
                                        <input type="file" name="image6" id="image6" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    @if(isset($game->image6))
                                        <img src="{{ $game->image6 }}" alt="{{ $game->name }} Resim6" title="{{ $game->name }} Resim6" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    @endif
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-primary form-label font-weight-bold">Resim7</label>
                                    <div class="row col">
                                        <input type="file" name="image7" id="image7" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    @if(isset($game->image7))
                                        <img src="{{ $game->image7 }}" alt="{{ $game->name }} Resim7" title="{{ $game->name }} Resim7" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mt-2 shadow align-top">
                        <div class="card-header font-weight-bold text-secondary" data-toggle="collapse" href="#game-videos" role="button" aria-expanded="true" aria-controls="game-videos">
                            Oyun Videoları
                        </div>
                        <div class="card-body collapse show" id="game-videos">
                            <div class="form-group col-sm-3">
                                <label for="video-count" class="text-primary form-label font-weight-bold">Video Sayısı</label>
                                <select class="form-select video-count" id="video-count" name="video_count">
                                    @for($i = 1; $i <= config('game_config.video_count'); $i++)
                                        <option value="{{ $i }}" @if($game->videos->count() == $i) selected="selected" @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <hr>
                            <div class="col-sm">
                                <a href="https://support.google.com/youtube/answer/171780?hl=tr" class="text-danger text-decoration-none d-inline-block mb-1" target="_blank">Youtube Video Ekleme Yardım İçin Tıklayınız</a>
                                @foreach($game->videos as $video)
                                    <div class="form-group" id="video-input-{{ $video_count }}">
                                        <label for="url{{ $video_count }}" class="text-primary form-label font-weight-bold">Video{{ $video_count }}</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">https://www.youtube.com/embed/</div>
                                            </div>
                                            <input type="text" class="form-control" id="url{{ $video_count }}" name="url[]" placeholder="Video Linki Giriniz" value="{{ substr($video->url, strpos($video->url, 'embed/') + 6) }}" required>
                                            <input type="hidden" name="video_hash[]" value="{{ $video->video_hash }}"/>
                                            <div class="invalid-feedback">
                                                Lütfen geçerli bir video URL adresi girin.
                                            </div>
                                        </div>
                                        <div class="embed-responsive embed-responsive-16by9" id="youtube-video-{{ $video_count }}">
                                            <div class="embed-responsive-item">
                                                <iframe src="{{ $video->url }}" class="mt-2 rounded" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    @php $video_count++; @endphp
                                    @if(!$loop->last) <div id="hr-div"><hr></div> @endif
                                @endforeach
                                <div class="other-videos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                <a href="{{route('admin.games')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
            </div>
        </form>
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       var video_limit         = {{ $video_limit }};
       var current_video_count = {{ $game->videos->count() }};
       var video_count         = parseInt($('.video-count').val());

       $('.video-count').change(function() {
          $('.other-videos').html('');

          if(parseInt($('.video-count').val()) == 1) {
             $('#hr-div').html('');
          }

          var video_count = parseInt($(this).val());

          if (video_count < current_video_count) {
             for (var x = video_count; x < current_video_count; x++) {
                $('#video-input-' + (x + 1)).remove();
             }
             current_video_count = video_count;
          }

          if (video_count > current_video_count) {
             for (var i = current_video_count; i < video_count; i++) {
                $('.other-videos').append('<div class="form-group" id="video-input-' + (i + 1) + '"><label for="video' + (i + 1) + '" class="text-primary form-label font-weight-bold">Video' + (i + 1) + '</label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">https://www.youtube.com/embed/</div></div><input type="text" class="form-control" id="video' + (i + 1) + '" name="url[]" placeholder="Video Linkini Giriniz" required/><div class="invalid-feedback">Lütfen geçerli bir video URL adresi girin.</div><input type="hidden" name="video_hash[]" value="' + strRandom(20) + '"/></div></div>');
             }
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