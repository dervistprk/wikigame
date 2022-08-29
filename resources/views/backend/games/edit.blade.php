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
                                    <select class="form-select select2" id="category" name="category_id" required>
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
                                        @foreach(config('game_config.age_ratings') as $age_rating)
                                            <option value="{{ $age_rating }}" @if($game->details->age_rating == $age_rating) selected="selected" @endif>{{ $age_rating }}</option>
                                        @endforeach
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
                                    <select class="form-select select2" id="developer" name="developer_id" required>
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
                                    <select class="form-select select2" id="publisher" name="publisher_id" required>
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
                                    <select multiple class="form-select select2" id="platform" name="platform_id[]" size="7" required>
                                        @foreach($platforms as $platform_id => $platform)
                                            <option value="{{ $platform_id }}" @if(in_array($platform_id, $game->platforms->pluck('id')->toArray())) selected="selected" @endif >{{ $platform }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Lütfen bir platform seçin.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="genre" class="text-primary col-form-label font-weight-bold">Tür*</label>
                                    <select multiple class="form-select select2" id="genre" name="genre_id[]" size="7" required>
                                        @foreach($genres as $genre_id => $genre)
                                            <option value="{{ $genre_id }}" @if(in_array($genre_id, $game->genres->pluck('id')->toArray())) selected="selected" @endif >{{ $genre }}</option>
                                        @endforeach
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
                            <div class="form-group col-sm-3">
                                <label for="image-count" class="text-primary form-label font-weight-bold">Resim Sayısı</label>
                                <select class="form-select image-count" id="image-count" name="image_count">
                                    @for($i = 1; $i <= config('game_config.image_count'); $i++)
                                        <option value="{{ $i }}" @if($game->images->count() + 1 == $i) selected="selected" @endif @if($game->images->count() + 1 > $i) disabled @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <hr>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cover_image" class="text-primary form-label font-weight-bold">Kapak Resmi*</label>
                                    <div class="row col">
                                        <input type="file" name="cover_image" id="cover_image" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    <img src="{{ $game->cover_image }}" alt="{{ $game->name }} Kapak Resmi" title="{{ $game->name }} Kapak Resmi" class="mt-1 rounded img-fluid img-thumbnail" width="175" height="225">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="image1" class="text-primary form-label font-weight-bold">Resim1*</label>
                                    <div class="row col">
                                        <input type="file" name="image1" id="image1" class="form-control-file btn btn-primary btn-sm btn-block">
                                    </div>
                                    <img src="{{ $game->image1 }}" alt="{{ $game->name }} Resim1" title="{{ $game->name }} Resim1" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                </div>
                                <hr>
                                @foreach($game->images as $image)
                                    <div class="form-group" id="image-input-{{ $image_count + 1 }}">
                                        <label for="image{{ $image_count + 1 }}" class="text-primary form-label font-weight-bold">Resim{{ $image_count + 1 }}*</label>
                                        @if(!$loop->first)
                                            <div class="col-sm-3 float-end">
                                                <a class="btn btn-danger btn-sm text-white" data-toggle="modal" data-target="#delete-image-{{ $image_count + 1 }}"><i class="fa fa-trash-alt"></i> Sil</a>
                                            </div>
                                            @include('backend.modals.deleteImageConfirmation')
                                        @endif
                                        <div class="row col">
                                            <input type="file" name="path[]" id="image{{ $image_count + 1 }}" class="form-control-file btn btn-primary btn-sm btn-block">
                                            <input type="hidden" name="image_hash[]" id="image-hash" value="{{ $image->image_hash }}"/>
                                        </div>
                                        <img src="{{ $image->path }}" alt="{{ $game->name }} Resim{{ $image_count + 1 }}" title="{{ $game->name }} Resim{{ $image_count + 1 }}" class="mt-1 rounded img-fluid img-thumbnail" width="500" height="300">
                                    </div>
                                    @php $image_count++; @endphp
                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                                <div class="other-images col-sm"></div>
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
                                        <option value="{{ $i }}" @if($game->videos->count() == $i) selected="selected" @endif @if($game->videos->count() > $i) disabled @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <hr>
                            <div class="col-sm">
                                <a href="https://support.google.com/youtube/answer/171780?hl=tr" class="text-info text-decoration-none d-inline-block mb-1" target="_blank">Youtube Video Ekleme Yardım İçin Tıklayınız</a>
                                @foreach($game->videos as $video)
                                    <div class="form-group" id="video-input-{{ $video_count }}">
                                        <label for="url{{ $video_count }}" class="text-primary form-label font-weight-bold">Video{{ $video_count }}*</label>
                                        @if(!$loop->first)
                                            <a class="btn btn-danger btn-sm text-white float-end mb-2" data-toggle="modal" data-target="#delete-video-{{ $video_count }}"><i class="fa fa-trash-alt"></i> Sil</a>
                                            @include('backend.modals.deleteVideoConfirmation')
                                        @endif
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
                                    @if(!$loop->last)
                                        <div id="hr-div">
                                            <hr>
                                        </div>
                                    @endif
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
       $(document).ready(function() {
          $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });

          $('.video-count').change(function() {
             $('.other-videos').html('');
             var video_count         = $(this).val();
             var current_video_count = {{ $video_count }};

             for (var i = current_video_count; i <= video_count; i++) {
                $('.other-videos').append('<div class="form-group" id="video-input-' + i + '"><label for="video' + i + '" class="text-primary form-label font-weight-bold">Video' + i + '</label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">https://www.youtube.com/embed/</div></div><input type="text" class="form-control" id="video' + i + '" name="url[]" placeholder="Video Linkini Giriniz" required/><div class="invalid-feedback">Lütfen geçerli bir video URL adresi girin.</div><input type="hidden" name="video_hash[]" value="' + strRandom(20) + '"/></div></div>');
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

          $('.image-count').change(function() {
             $('.other-images').html('');
             var image_count         = $(this).val();
             var current_image_count = {{ $image_count }};

             for (var i = current_image_count; i < image_count; i++) {
                $('.other-images').append('<div class="form-group row"><label for="image' + (i + 1) + '" class="text-primary form-label font-weight-bold">Resim' + (i + 1) + '*</label><input type="file" class="form-control-file btn btn-primary btn-sm btn-block" id="image' + (i + 1) + '" name="path[]" required/><input type="hidden" name="image_hash[]" value="' + strRandom(20) + '"/><div class="invalid-feedback">Lütfen resim seçin.</div></div>');
             }
          });

          $('.delete-image-btn').click(function() {
             var image_hash = $(this).siblings('#image-hash-modal').val();
             $.ajax({
                url       : "{{ route('admin.delete-single-game-image') }}",
                type      : 'post',
                data      : {
                   game_id   : {{ $game->id }},
                   image_hash: image_hash
                },
                beforeSend: function() {
                   $('.delete-image-btn').find('.fa-trash-alt').removeClass('fa-trash-alt').addClass('fa-spinner fa-spin');
                },
                success   : function(response) {
                   if (response.result) {
                      alert(response.message);
                      location.reload();
                   } else {
                      alert(response.message);
                      location.reload();
                   }
                },
                error     : function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
             });
          });

          $('.delete-video-btn').click(function() {
             var video_hash = $(this).siblings('#video-hash-modal').val();

             $.ajax({
                url       : "{{ route('admin.delete-game-video') }}",
                type      : 'post',
                data      : {
                   game_id   : {{ $game->id }},
                   video_hash: video_hash
                },
                beforeSend: function() {
                   $('.delete-video-btn').find('.fa-trash-alt').removeClass('fa-trash-alt').addClass('fa-spinner fa-spin');
                },
                success   : function(response) {
                   if (response.result) {
                      alert(response.message);
                      location.reload();
                   } else {
                      alert(response.message);
                      location.reload();
                   }
                },
                error     : function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
             });
          });

          //stop video if modal is closed
          $('.modal').on('hidden.bs.modal', function() {
             $('.modal iframe').attr('src', $('.modal iframe').attr('src'));
          });
       });
    </script>
@endsection