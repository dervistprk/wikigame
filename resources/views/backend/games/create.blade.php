@extends('layouts.backend')
@section('title', 'Oyun Ekle')
@section('content')
    <div class="container">
        <form class="mt-2 needs-validation" method="post" novalidate action="{{route('admin.create-game-post')}}" enctype="multipart/form-data">
            @if($errors->any())
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger alert-dismissible fade show">
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
                                    <select class="form-select select2" id="category" name="category_id" required>
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
                                <div class="form-group">
                                    <label for="age_rating" class="text-primary col-form-label font-weight-bold">Yaş Sınırı*</label>
                                    <select class="form-select" id="age_rating" name="age_rating" required>
                                        <option value="" hidden>Yaş Sınırı Seçiniz</option>
                                        @foreach(config('game_config.age_ratings') as $age_rating)
                                            <option value="{{ $age_rating }}" @if(old('age_rating') == $age_rating) selected="selected" @endif>{{ $age_rating }}</option>
                                        @endforeach
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
                                    <select class="form-select select2" id="developer" name="developer_id" required>
                                        <option value="" hidden>Geliştirici Seçiniz</option>
                                        @foreach($developers as $developer)
                                            <option value="{{ $developer->id }}" @if(old('developer_id') == $developer->id) selected="selected" @endif>{{ $developer->name }}</option>
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
                                    <select class="form-select select2" id="publisher" name="publisher_id" required>
                                        <option value="" hidden>Dağıtıcı Seçiniz</option>
                                        @foreach($publishers as $publisher)
                                            <option value="{{ $publisher->id }}" @if(old('publisher_id') == $publisher->id) selected="selected" @endif>{{ $publisher->name }}</option>
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
                                    <select multiple="multiple" class="form-select select2" id="platform" name="platform_id[]" size="7" required>
                                        <option value="" hidden>Platform Seçiniz</option>
                                        @foreach($platforms as $platform)
                                            <option value="{{ $platform->id }}" @if(old('platform_id')) @if(in_array($platform->id, old('platform_id'))) selected="selected"@endif @endif>{{ $platform->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen oyun platformu seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="genre" class="text-primary col-form-label font-weight-bold">Tür*</label>
                                    <select multiple="multiple" class="form-select select2" id="genre" name="genre_id[]" size="7" required>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}" @if(old('genre_id')) @if(in_array($genre->id, old('genre_id'))) selected="selected"@endif @endif>{{ $genre->name }}</option>
                                        @endforeach
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
                                    <label for="cpu_min" class="text-primary form-label font-weight-bold">İşlemci*</label>
                                    <input type="text" class="form-control" id="cpu_min" name="cpu_min" placeholder="İşlemci Giriniz" value="{{ old('cpu_min') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işlemci girin.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gpu_min" class="text-primary form-label font-weight-bold">Ekran Kartı*</label>
                                    <input type="text" class="form-control" id="gpu_min" name="gpu_min" placeholder="Ekran Kartı Giriniz" value="{{ old('gpu_min') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen ekran kartı girin.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="ram_min" class="text-primary col-form-label font-weight-bold">Bellek*</label>
                                            <input type="number" class="form-control" id="ram_min" name="ram_min" placeholder="Bellek Giriniz" value="{{ old('ram_min') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen bellek girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ram_min_unit" class="text-primary col-form-label font-weight-bold">Birim*</label>
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
                                            <label for="storage_min" class="text-primary col-form-label font-weight-bold">Depolama Alanı*</label>
                                            <input type="number" class="form-control" id="storage_min" name="storage_min" placeholder="Depolama Alanı Giriniz" value="{{ old('storage_min') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen depolama alanı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="storage_min_unit" class="text-primary col-form-label font-weight-bold">Birim*</label>
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
                                    <label for="os_min" class="text-primary form-label font-weight-bold">İşletim Sistemi*</label>
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
                                    <label for="cpu_rec" class="text-primary form-label font-weight-bold">İşlemci*</label>
                                    <input type="text" class="form-control" id="cpu_rec" name="cpu_rec" placeholder="İşlemci Giriniz" value="{{ old('cpu_rec') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen işlemci girin.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gpu_rec" class="text-primary form-label font-weight-bold">Ekran Kartı*</label>
                                    <input type="text" class="form-control" id="gpu_rec" name="gpu_rec" placeholder="Ekran Kartı Giriniz" value="{{ old('gpu_rec') }}" required>
                                    <div class="invalid-feedback">
                                        Lütfen ekran kartı girin.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="ram_rec" class="text-primary col-form-label font-weight-bold">Bellek*</label>
                                            <input type="number" class="form-control" id="ram_rec" name="ram_rec" placeholder="Bellek Giriniz" value="{{ old('ram_rec') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen bellek girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="ram_rec_unit" class="text-primary col-form-label font-weight-bold">Birim*</label>
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
                                            <label for="storage_rec" class="text-primary col-form-label font-weight-bold">Depolama Alanı*</label>
                                            <input type="number" class="form-control" id="storage_rec" name="storage_rec" placeholder="Depolama Alanı Giriniz" value="{{ old('storage_rec') }}" required>
                                            <div class="invalid-feedback">
                                                Lütfen depolama alanı girin.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="storage_rec_unit" class="text-primary col-form-label font-weight-bold">Birim*</label>
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
                                    <label for="os_rec" class="text-primary form-label font-weight-bold">İşletim Sistemi*</label>
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
                            <div class="form-group col-sm-3">
                                <label for="image-count" class="text-primary form-label font-weight-bold">Resim Sayısı</label>
                                <select class="form-select image-count" id="image-count" name="image_count">
                                    @for($i = 1; $i <= config('game_config.image_count'); $i++)
                                        <option value="{{ $i }}" @if(old('image_count' == $i)) selected="selected" @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm">
                                <div class="row col">
                                    <label for="cover_image" class="text-primary form-label font-weight-bold">Kapak Resmi*</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control-file btn btn-primary btn-sm btn-block" required>
                                    <div class="invalid-feedback">
                                        Lütfen oyun kapak resmi seçin.
                                    </div>
                                </div>
                                <div class="row col mt-2">
                                    <label for="image1" class="text-primary form-label font-weight-bold">Resim1*</label>
                                    <input type="file" name="image1" id="image1" class="form-control-file btn btn-primary btn-sm btn-block" required>
                                    <div class="invalid-feedback">
                                        Lütfen resim seçin.
                                    </div>
                                    <div class="other-images mt-2"></div>
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
       $(document).ready(function() {
          $('.video-count').change(function() {
             $('.other-videos').html('');
             var video_count = $(this).val();

             for (var i = 1; i < video_count; i++) {
                $('.other-videos').append('<div class="form-group"><label for="video' + (i + 1) + '" class="text-primary form-label font-weight-bold">Video' + (i + 1) + '*</label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">https://www.youtube.com/embed/</div></div><input type="text" class="form-control" id="video' + (i + 1) + '" name="url[]" placeholder="Video Linkini Giriniz" required/><input type="hidden" name="video_hash[]" value="' + strRandom(20) + '"/><div class="invalid-feedback">Lütfen geçerli bir video URL adresi girin.</div></div></div>');
             }
          });

          $('.image-count').change(function() {
             $('.other-images').html('');
             var image_count = $(this).val();

             for (var i = 1; i < image_count; i++) {
                $('.other-images').append('<div class="form-group row"><label for="image' + (i + 1) + '" class="text-primary form-label font-weight-bold">Resim' + (i + 1) + '*</label><input type="file" class="form-control-file btn btn-primary btn-sm btn-block" id="image' + (i + 1) + '" name="path[]" required/><input type="hidden" name="image_hash[]" value="' + strRandom(20) + '"/><div class="invalid-feedback">Lütfen resim seçin.</div></div>');
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
       });
    </script>
@endsection