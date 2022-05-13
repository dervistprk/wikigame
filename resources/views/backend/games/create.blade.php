@extends('layouts.backend')
@section('title', 'Oyun Ekle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.create-game-post')}}" enctype="multipart/form-data">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif
        @csrf
        <div class="card">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-gamepad"></i>
                Oyun Ekle <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="text-primary font-weight-bold">Adı*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Oyun Adını Giriniz" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="text-primary font-weight-bold">Altbaşlık*</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Oyun Altbaşlığını Giriniz" value="{{ old('subtitle') }}" required>
                </div>
                <div class="form-group">
                    <label for="category" class="text-primary font-weight-bold">Kategori*</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Kategori Seçiniz</option>
                        @foreach($categories as $category)
                            @if (old('category') == $category->id)
                                <option value={{ $category->id }} selected>{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="developer" class="text-primary font-weight-bold">Geliştirici*</label>
                    <select class="form-control" id="developer" name="developer" required>
                        <option value="">Geliştirici Seçiniz</option>
                        @foreach($developers as $developer)
                            @if (old('developer') == $developer->id)
                                <option value={{ $developer->id }} selected>{{ $developer->name }}</option>
                            @else
                                <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="publisher" class="text-primary font-weight-bold">Dağıtıcı*</label>
                    <select class="form-control" id="publisher" name="publisher" required>
                        <option value="">Dağıtıcı Seçiniz</option>
                        @foreach($publishers as $publisher)
                            @if (old('publisher') == $publisher->id)
                                <option value={{ $publisher->id }} selected>{{ $publisher->name }}</option>
                            @else
                                <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group"> <!--TODO: age_rating, platform ve genre için ayrı tablolar oluşturup modelleri bağla ve ilgili her yeri düzenle -->
                    <label for="age_rating" class="text-primary font-weight-bold">Yaş Sınırı*</label>
                    <select class="form-control" id="age_rating" name="age_rating">
                        <option value="">Yaş Sınırı Seçiniz</option>
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
                </div>
                <div class="form-group">
                    <label for="platform" class="text-primary font-weight-bold">Platform*</label>
                    <select multiple class="form-control" id="platform" name="platform[]" size="7">
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
                </div>
                <div class="form-group">
                    <label for="genre" class="text-primary font-weight-bold">Tür*</label>
                    <select multiple class="form-control" id="genre" name="genre[]" size="7">
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
                </div>
                <div class="form-group">
                    <label for="release_date" class="text-primary font-weight-bold">Çıkış Tarihi*</label>
                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date') }}">
                </div>
                <div class="form-group">
                    <label for="website" class="text-primary font-weight-bold">Resmi İnternet Sitesi*</label>
                    <input type="text" class="form-control" id="website" name="website" value="{{ old('website') }}">
                </div>
                <div class="form-group">
                    <label for="description" class="text-primary font-weight-bold">Oyun Açıklaması*</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Oyun Açıklaması Giriniz" required>{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card mt-2 d-inline-block" style="width: 48%">
            <div class="card-header font-weight-bold text-secondary">
                Minimum Sistem Gereksinimleri*
            </div>
            <div class="card-body">
                <div class="form-group col-md">
                    <label for="cpu_min" class="text-primary font-weight-bold">İşlemci</label>
                    <input type="text" class="form-control" id="cpu_min" name="cpu_min" placeholder="İşlemci Giriniz" value="{{ old('cpu_min') }}">
                </div>
                <div class="form-group col-md">
                    <label for="gpu_min" class="text-primary font-weight-bold">Ekran Kartı</label>
                    <input type="text" class="form-control" id="gpu_min" name="gpu_min" placeholder="Ekran Kartı Giriniz" value="{{ old('gpu_min') }}">
                </div>
                <div class="form-group d-inline-block col-md-6">
                    <label for="ram_min" class="text-primary font-weight-bold">Bellek</label>
                    <input type="number" class="form-control" id="ram_min" name="ram_min" placeholder="Bellek Giriniz" value="{{ old('ram_min') }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="ram_min_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="ram_min_unit" name="ram_min_unit">
                        @if(old('ram_min_unit') == 0)
                            <option value="0" selected="selected">MB</option>
                            <option value="1">GB</option>
                        @elseif(old('ram_min_unit') == 1)
                            <option value="0">MB</option>
                            <option value="1" selected="selected">GB</option>
                        @else
                            <option value="0">MB</option>
                            <option value="1">GB</option>
                        @endif
                    </select>
                </div>
                <div class="form-group d-inline-block col-md-6">
                    <label for="storage_min" class="text-primary font-weight-bold">Depolama Alanı</label>
                    <input type="number" class="form-control" id="storage_min" name="storage_min" placeholder="Depolama Alanı Giriniz" value="{{ old('storage_min') }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="storage_min_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="storage_min_unit" name="storage_min_unit">
                        @if(old('storage_min_unit') == 0)
                            <option value="0" selected="selected">MB</option>
                            <option value="1">GB</option>
                        @elseif(old('storage_min_unit') == 1)
                            <option value="0">MB</option>
                            <option value="1" selected="selected">GB</option>
                        @else
                            <option value="0">MB</option>
                            <option value="1">GB</option>
                        @endif
                    </select>
                </div>
                <div class="form-group col">
                    <label for="os_min" class="text-primary font-weight-bold">İşletim Sistemi</label>
                    <input type="text" class="form-control" id="os_min" name="os_min" placeholder="İşletim Sistemi Giriniz" value="{{ old('os_min') }}">
                </div>
            </div>
        </div>
        <div class="card mt-2 m-lg-3 d-inline-block" style="width: 48%">
            <div class="card-header font-weight-bold text-secondary">
                Önerilen Sistem Gereksinimleri*
            </div>
            <div class="card-body">
                <div class="form-group col">
                    <label for="cpu_rec" class="text-primary font-weight-bold">İşlemci</label>
                    <input type="text" class="form-control" id="cpu_rec" name="cpu_rec" placeholder="İşlemci Giriniz" value="{{ old('cpu_rec') }}">
                </div>
                <div class="form-group col">
                    <label for="gpu_rec" class="text-primary font-weight-bold">Ekran Kartı</label>
                    <input type="text" class="form-control" id="gpu_rec" name="gpu_rec" placeholder="Ekran Kartı Giriniz" value="{{ old('gpu_rec') }}">
                </div>
                <div class="form-group d-inline-block col-md-6">
                    <label for="ram_rec" class="text-primary font-weight-bold">Bellek</label>
                    <input type="number" class="form-control" id="ram_rec" name="ram_rec" placeholder="Bellek Giriniz" value="{{ old('ram_rec') }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="ram_rec_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="ram_rec_unit" name="ram_rec_unit">
                        @if(old('ram_rec_unit') == 0)
                            <option value="0" selected="selected">MB</option>
                            <option value="1">GB</option>
                        @elseif(old('ram_rec_unit') == 1)
                            <option value="0">MB</option>
                            <option value="1" selected="selected">GB</option>
                        @else
                            <option value="0">MB</option>
                            <option value="1">GB</option>
                        @endif
                    </select>
                </div>
                <div class="form-group d-inline-block col-md-6">
                    <label for="storage_rec" class="text-primary font-weight-bold">Depolama Alanı</label>
                    <input type="number" class="form-control" id="storage_rec" name="storage_rec" placeholder="Depolama Alanı Giriniz" value="{{ old('storage_rec') }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="storage_rec_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="storage_rec_unit" name="storage_rec_unit">
                        @if(old('storage_rec_unit') == 0)
                            <option value="0" selected="selected">MB</option>
                            <option value="1">GB</option>
                        @elseif(old('storage_rec_unit') == 1)
                            <option value="0">MB</option>
                            <option value="1" selected="selected">GB</option>
                        @else
                            <option value="0">MB</option>
                            <option value="1">GB</option>
                        @endif
                    </select>
                </div>
                <div class="form-group col">
                    <label for="os_rec" class="text-primary font-weight-bold">İşletim Sistemi</label>
                    <input type="text" class="form-control" id="os_rec" name="os_rec" placeholder="İşletim Sistemi Giriniz" value="{{ old('os_rec') }}">
                </div>
            </div>
        </div>
        <div class="card mt-3 d-inline-block" style="width: 48%">
            <div class="card-header font-weight-bold text-secondary">
                Oyun Resimleri
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="cover_image" class="text-primary font-weight-bold">Kapak Resmi*</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control btn btn-primary btn-sm" required>
                </div>
                <div class="form-group">
                    <label for="image1" class="text-primary font-weight-bold">Resim1*</label>
                    <input type="file" name="image1" id="image1" class="form-control btn btn-primary btn-sm" required>
                </div>
                <div class="form-group">
                    <label for="image2" class="text-primary font-weight-bold">Resim2</label>
                    <input type="file" name="image2" id="image2" class="form-control btn btn-primary btn-sm">
                </div>
                <div class="form-group">
                    <label for="image3" class="text-primary font-weight-bold">Resim3</label>
                    <input type="file" name="image3" id="image3" class="form-control btn btn-primary btn-sm">
                </div>
                <div class="form-group">
                    <label for="image4" class="text-primary font-weight-bold">Resim4</label>
                    <input type="file" name="image4" id="image4" class="form-control btn btn-primary btn-sm">
                </div>
                <div class="form-group">
                    <label for="image5" class="text-primary font-weight-bold">Resim5</label>
                    <input type="file" name="image5" id="image5" class="form-control btn btn-primary btn-sm">
                </div>
                <div class="form-group">
                    <label for="image6" class="text-primary font-weight-bold">Resim6</label>
                    <input type="file" name="image6" id="image6" class="form-control btn btn-primary btn-sm">
                </div>
                <div class="form-group">
                    <label for="image7" class="text-primary font-weight-bold">Resim7</label>
                    <input type="file" name="image7" id="image7" class="form-control btn btn-primary btn-sm">
                </div>
            </div>
        </div>
        <div class="card m-lg-3 d-inline-block align-top" style="width: 48%">
            <div class="card-header font-weight-bold text-secondary">
                Oyun Videoları
            </div>
            <div class="card-body">
                <a href="https://support.google.com/youtube/answer/171780?hl=tr" class="text-danger text-decoration-none d-inline-block mb-1" target="_blank">Youtube Video Ekleme Yardım İçin Tıklayınız</a>
                <div class="form-group">
                    <label for="video1" class="text-primary font-weight-bold">Video1*</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">https://www.youtube.com/embed/</div>
                        </div>
                        <input type="text" class="form-control" id="video1" name="video1" placeholder="Video Linkini Giriniz" value="{{ old('video1') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="video2" class="text-primary font-weight-bold">Video2</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">https://www.youtube.com/embed/</div>
                        </div>
                        <input type="text" class="form-control" id="video2" name="video2" placeholder="Video Linkini Giriniz" value="{{ old('video2') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="video3" class="text-primary font-weight-bold">Video3</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">https://www.youtube.com/embed/</div>
                        </div>
                        <input type="text" class="form-control" id="video3" name="video3" placeholder="Video Linkini Giriniz" value="{{ old('video3') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="video4" class="text-primary font-weight-bold">Video4</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">https://www.youtube.com/embed/</div>
                        </div>
                        <input type="text" class="form-control" id="video4" name="video4" placeholder="Video Linkini Giriniz" value="{{ old('video4') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="video5" class="text-primary font-weight-bold">Video5</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">https://www.youtube.com/embed/</div>
                        </div>
                        <input type="text" class="form-control" id="video5" name="video5" placeholder="Video Linkini Giriniz" value="{{ old('video5') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-3 text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.games')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
        </div>
    </form>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                    toolbar: [
                        ['style', ['style']],
                        ['fontsize', ['fontsize']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['picture', 'hr']],
                        ['table', ['table']]
                    ],
                    fontSizes: ['8', '9', '10', '11', '12', '14','16', '18', '20', '22', '24', '36', '48', '64', '82', '150'],
                    height: 400,
                    focus: false
                }
            );
        });
    </script>
@endsection

