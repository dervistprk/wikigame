@extends('layouts.backend')
@section('title', 'Oyun Düzenle')
@section('content')
    <form class="container mt-2" method="post" action="{{route('admin.edit-game-post', [$game->id])}}" enctype="multipart/form-data">
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
                Oyun Bilgileri <span class="float-end text-secondary">* Zorunlu Alanlar</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="text-primary font-weight-bold">Adı*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Oyun Adını Giriniz" value="{{ $game->name }}" required>
                </div>
                <div class="form-group">
                    <label for="subtitle" class="text-primary font-weight-bold">Altbaşlık*</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Oyun Altbaşlığını Giriniz" value="{{ $game->sub_title }}" required>
                </div>
                <div class="form-group">
                    <label for="category" class="text-primary font-weight-bold">Kategori*</label>
                    <select class="form-control" id="category" name="category" required>
                        @foreach($categories as $category)
                            <option @if($game->category_id == $category->id) selected="selected" @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="developer" class="text-primary font-weight-bold">Geliştirici*</label>
                    <select class="form-control" id="developer" name="developer" required>
                        @foreach($developers as $developer)
                            <option @if($game->developer_id == $developer->id) selected="selected" @endif value="{{ $developer->id }}">{{ $developer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="publisher" class="text-primary font-weight-bold">Dağıtıcı*</label>
                    <select class="form-control" id="publisher" name="publisher" required>
                        @foreach($publishers as $publisher)
                            <option @if($game->publisher_id == $publisher->id) selected="selected" @endif value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="age_rating" class="text-primary font-weight-bold">Yaş Sınırı*</label>
                    <select class="form-control" id="age_rating" name="age_rating">
                        <option @if($game->details->age_rating == 3) selected="selected" @endif value="3">3</option>
                        <option @if($game->details->age_rating == 7) selected="selected" @endif value="7">7</option>
                        <option @if($game->details->age_rating == 12) selected="selected" @endif value="12">12</option>
                        <option @if($game->details->age_rating == 16) selected="selected" @endif value="16">16</option>
                        <option @if($game->details->age_rating == 18) selected="selected" @endif value="18">18</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status" class="text-primary font-weight-bold">Durum*</label>
                    <select class="form-control" id="status" name="status">
                        <option @if($game->status == 0) selected="selected" @endif value="0">Pasif</option>
                        <option @if($game->status == 1) selected="selected" @endif value="1">Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="platform" class="text-primary font-weight-bold">Platform*</label>
                    <select multiple class="form-control" id="platform" name="platform[]" size="7">
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
                </div>
                <div class="form-group">
                    <label for="genre" class="text-primary font-weight-bold">Tür*</label>
                    <select multiple class="form-control" id="genre" name="genre[]" size="7">
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
                </div>
                <div class="form-group">
                    <label for="release_date" class="text-primary font-weight-bold">Çıkış Tarihi*</label>
                    <input type="date" class="form-control" id="release_date" name="release_date" value="{{ $game->details->release_date }}">
                </div>
                <div class="form-group">
                    <label for="website" class="text-primary font-weight-bold">Resmi İnternet Sitesi*</label>
                    <input type="text" class="form-control" id="website" name="website" value="{{ $game->details->website }}">
                </div>
                <div class="form-group">
                    <label for="description" class="text-primary font-weight-bold">Oyun Açıklaması*</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Oyun Açıklaması Giriniz" required>{{ $game->description }}</textarea>
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
                    <input type="text" class="form-control" id="cpu_min" name="cpu_min" placeholder="İşlemci Giriniz" value="{{ $game->systemReqMin->cpu }}">
                </div>
                <div class="form-group col-md">
                    <label for="gpu_min" class="text-primary font-weight-bold">Ekran Kartı</label>
                    <input type="text" class="form-control" id="gpu_min" name="gpu_min" placeholder="Ekran Kartı Giriniz" value="{{ $game->systemReqMin->gpu }}">
                </div>
                <div class="form-group d-inline-block col-md-6">
                    <label for="ram_min" class="text-primary font-weight-bold">Bellek</label>
                    <input type="number" class="form-control" id="ram_min" name="ram_min" placeholder="Bellek Giriniz" value="{{ $game->systemReqMin->ram }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="ram_min_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="ram_min_unit" name="ram_min_unit">
                        <option value="0" @if($game->systemReqMin->ram_unit == 0) selected="selected"@endif>MB</option>
                        <option value="1" @if($game->systemReqMin->ram_unit == 1) selected="selected"@endif>GB</option>
                    </select>
                </div>
                <div class="form-group d-inline-block col-md-6">
                    <label for="storage_min" class="text-primary font-weight-bold">Depolama Alanı</label>
                    <input type="number" class="form-control" id="storage_min" name="storage_min" placeholder="Depolama Alanı Giriniz" value="{{ $game->systemReqMin->storage }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="storage_min_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="storage_min_unit" name="storage_min_unit">
                        <option value="0" @if($game->systemReqMin->storage_unit == 0) selected="selected"@endif>MB</option>
                        <option value="1" @if($game->systemReqMin->storage_unit == 1) selected="selected"@endif>GB</option>
                    </select>
                </div>
                <div class="form-group col-md">
                    <label for="os_min" class="text-primary font-weight-bold">İşletim Sistemi</label>
                    <input type="text" class="form-control" id="os_min" name="os_min" placeholder="İşletim Sistemi Giriniz" value="{{ $game->systemReqMin->os }}">
                </div>
            </div>
        </div>
        <div class="card mt-2 m-lg-3 d-inline-block" style="width: 48%">
            <div class="card-header font-weight-bold text-secondary">
                Önerilen Sistem Gereksinimleri*
            </div>
            <div class="card-body">
                <div class="form-group col-md">
                    <label for="cpu_rec" class="text-primary font-weight-bold">İşlemci</label>
                    <input type="text" class="form-control" id="cpu_rec" name="cpu_rec" placeholder="İşlemci Giriniz" value="{{ $game->systemReqRec->cpu }}">
                </div>
                <div class="form-group col-md">
                    <label for="gpu_rec" class="text-primary font-weight-bold">Ekran Kartı</label>
                    <input type="text" class="form-control" id="gpu_rec" name="gpu_rec" placeholder="Ekran Kartı Giriniz" value="{{ $game->systemReqRec->gpu }}">
                </div>
                <div class="form-group col-md d-inline-block col-md-6">
                    <label for="ram_rec" class="text-primary font-weight-bold">Bellek</label>
                    <input type="number" class="form-control" id="ram_rec" name="ram_rec" placeholder="Bellek Giriniz" value="{{ $game->systemReqRec->ram }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="ram_rec_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="ram_rec_unit" name="ram_rec_unit">
                        <option value="0" @if($game->systemReqRec->ram_unit == 0) selected="selected"@endif>MB</option>
                        <option value="1" @if($game->systemReqRec->ram_unit == 1) selected="selected"@endif>GB</option>
                    </select>
                </div>
                <div class="form-group col-md d-inline-block col-md-6">
                    <label for="storage_rec" class="text-primary font-weight-bold">Depolama Alanı</label>
                    <input type="number" class="form-control" id="storage_rec" name="storage_rec" placeholder="Depolama Alanı Giriniz" value="{{ $game->systemReqRec->storage }}">
                </div>
                <div class="form-group d-inline-block col-md-4">
                    <label for="storage_rec_unit" class="text-primary font-weight-bold">Birim</label>
                    <select class="form-control" id="storage_rec_unit" name="storage_rec_unit">
                        <option value="0" @if($game->systemReqRec->storage_unit == 0) selected="selected"@endif>MB</option>
                        <option value="1" @if($game->systemReqRec->storage_unit == 1) selected="selected"@endif>GB</option>
                    </select>
                </div>
                <div class="form-group col-md">
                    <label for="os_rec" class="text-primary font-weight-bold">İşletim Sistemi</label>
                    <input type="text" class="form-control" id="os_rec" name="os_rec" placeholder="İşletim Sistemi Giriniz" value="{{ $game->systemReqRec->os }}">
                </div>
            </div>
        </div>
        <div class="card mt-3 d-inline-block mb-3" style="width: 48%">
            <div class="card-header font-weight-bold text-secondary">
                Oyun Resimleri
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="cover_image" class="text-primary font-weight-bold">Kapak Resmi*</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control btn btn-primary btn-sm">
                    <img src="{{ $game->cover_image }}" alt="{{ $game->name }} Kapak Resmi" title="{{ $game->name }} Kapak Resmi" class="mt-1 rounded" width="175" height="225">
                </div>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim1*</label>
                    <input type="file" name="image1" id="image1" class="form-control btn btn-primary btn-sm">
                    <img src="{{ $game->image1 }}" alt="{{ $game->name }} Resim1" title="{{ $game->name }} Resim1" class="mt-1 rounded" width="500" height="300">
                </div>
                <hr>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim2</label>
                    <input type="file" name="image2" id="image2" class="form-control btn btn-primary btn-sm">
                    @if(isset($game->image2))
                        <img src="{{ $game->image2 }}" alt="{{ $game->name }} Resim2" title="{{ $game->name }} Resim2" class="mt-1 rounded" width="500" height="300">
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim3</label>
                    <input type="file" name="image3" id="image3" class="form-control btn btn-primary btn-sm">
                    @if(isset($game->image3))
                        <img src="{{ $game->image3 }}" alt="{{ $game->name }} Resim3" title="{{ $game->name }} Resim3" class="mt-1 rounded" width="500" height="300">
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim4</label>
                    <input type="file" name="image4" id="image4" class="form-control btn btn-primary btn-sm">
                    @if(isset($game->image4))
                        <img src="{{ $game->image4 }}" alt="{{ $game->name }} Resim4" title="{{ $game->name }} Resim4" class="mt-1 rounded" width="500" height="300">
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim5</label>
                    <input type="file" name="image5" id="image5" class="form-control btn btn-primary btn-sm">
                    @if(isset($game->image5))
                        <img src="{{ $game->image5 }}" alt="{{ $game->name }} Resim5" title="{{ $game->name }} Resim5" class="mt-1 rounded" width="500" height="300">
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim6</label>
                    <input type="file" name="image6" id="image6" class="form-control btn btn-primary btn-sm">
                    @if(isset($game->image6))
                        <img src="{{ $game->image6 }}" alt="{{ $game->name }} Resim6" title="{{ $game->name }} Resim6" class="mt-1 rounded" width="500" height="300">
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Resim7</label>
                    <input type="file" name="image7" id="image7" class="form-control btn btn-primary btn-sm">
                    @if(isset($game->image7))
                        <img src="{{ $game->image7 }}" alt="{{ $game->name }} Resim7" title="{{ $game->name }} Resim7" class="mt-1 rounded" width="500" height="300">
                    @endif
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
                    <input type="text" class="form-control" id="video1" name="video1" placeholder="Video Linki Giriniz" value="{{ $game->video1 }}">
                    <span class="form-text text-muted"><i>https://www.youtube.com/embed/</i> sonrasını düzenleyiniz.</span>
                    <iframe src="{{ $game->video1 }}" class="mt-2 rounded" width="500" height="300" allowfullscreen></iframe>
                </div>
                <hr>
                <div class="form-group">
                    <label for="video2" class="text-primary font-weight-bold">Video2</label>
                    <input type="text" class="form-control" id="video2" name="video2" placeholder="Video Linki Giriniz" value="{{ $game->video2 }}">
                    <span class="form-text text-muted"><i>https://www.youtube.com/embed/</i> sonrasını düzenleyiniz.</span>
                    @if(isset($game->video2))
                        <iframe src="{{ $game->video2 }}" class="mt-2 rounded" width="500" height="300" allowfullscreen></iframe>
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label for="video3" class="text-primary font-weight-bold">Video3</label>
                    <input type="text" class="form-control" id="video3" name="video3" placeholder="Video Linki Giriniz" value="{{ $game->video3 }}">
                    <span class="form-text text-muted"><i>https://www.youtube.com/embed/</i> sonrasını düzenleyiniz.</span>
                    @if(isset($game->video3))
                        <iframe src="{{ $game->video3 }}" class="mt-2 rounded" width="500" height="300" allowfullscreen></iframe>
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label for="video4" class="text-primary font-weight-bold">Video4</label>
                    <input type="text" class="form-control" id="video4" name="video4" placeholder="Video Linki Giriniz" value="{{ $game->video4 }}">
                    <span class="form-text text-muted"><i>https://www.youtube.com/embed/</i> sonrasını düzenleyiniz.</span>
                    @if(isset($game->video4))
                        <iframe src="{{ $game->video4 }}" class="mt-2 rounded" width="500" height="300" allowfullscreen></iframe>
                    @endif
                </div>
                <hr>
                <div class="form-group">
                    <label for="video5" class="text-primary font-weight-bold">Video5</label>
                    <input type="text" class="form-control" id="video5" name="video5" placeholder="Video Linki Giriniz" value="{{ $game->video5 }}">
                    <span class="form-text text-muted"><i>https://www.youtube.com/embed/</i> sonrasını düzenleyiniz.</span>
                    @if(isset($game->video5))
                        <iframe src="{{ $game->video5 }}" class="mt-2 rounded" width="500" height="300" allowfullscreen></iframe>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
            <a href="{{route('admin.games')}}" class="btn btn-danger"><i class="fa fa-backspace"></i> Vazgeç</a>
        </div>
    </form>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-tr-TR.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                toolbar: [
                    ['style'],
                    ['fontsize'],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontname'],
                    ['color'],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'hr', 'video']],
                    ['table', ['table']],
                    ['codeview', ['codeview']],
                    ['link', ['link']],
                    ['actions', ['undo', 'redo']],
                ],
                fontSizes: ['7', '8', '9', '10', '11', '12', '14','16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36', '48'],
                height: 400,
                focus: false,
                placeholder: 'Oyun Açıklaması Giriniz',
                dialogsFade: true,
                lang: 'tr-TR'
                }
            );
        });
    </script>
@endsection

