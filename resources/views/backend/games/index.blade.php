@extends('layouts.backend')
@section('title', 'Oyunlar')
@section('content')
    <div class="container-fluid">
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
            <a href="{{ route('admin.create-game') }}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus"></i> Oyun Ekle</a>
        </div>
        <div class="card mb-4 m-2 shadow text-secondary">
            <div class="card-header font-weight-bold">
                <i class="fas fa-gamepad"></i>
                Kayıtlı Oyunlar
                <div class="float-end">
                    <form class="form-inline" id="query-form" method="get" action="{{ route('admin.games') }}">
                        <input type="hidden" name="sort_by"/>
                        <input type="hidden" name="sort_dir"/>
                        <div class="m-2">
                            <label for="per-page" class="form-label">Öge Sayısı</label>
                            <select class="form-select" name="per_page" id="per-page">
                                @foreach(config('backend.per_page') as $config_per_page)
                                    <option value="{{ $config_per_page }}" @if($per_page == $config_per_page) selected @endif>{{ $config_per_page }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="m-2">
                            <label for="quick-search">Hızlı Ara</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $quick_search ?? null }}" name="quick_search" id="quick-search" placeholder="Oyun Ara"/>
                                <button class="btn btn-primary btn-sm mr-sm-2" id="btn-search" type="submit">
                                    <i id="search-icon" class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="m-2 mt-4">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#detailedSearch">
                                <i class="fa fa-info-circle"></i> Detaylı
                            </button>
                        </div>
                        <div class="m-2 mt-4">
                            <button type="button" id="reset-parameters" class="btn btn-sm btn-warning d-none" data-toggle="tooltip" data-placement="top" title="Temizle">
                                <i class="fa fa-undo"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($games->items())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th class="sorter" data-column="id">ID</th>
                                <th>Kapak Resmi</th>
                                <th class="sorter" data-column="name">Adı</th>
                                <th class="sorter" data-column="category_id">Kategori</th>
                                <th class="sorter" data-column="developer_id">Geliştirici</th>
                                <th class="sorter" data-column="publisher_id">Dağıtıcı</th>
                                <th>Platform</th>
                                <th>Tür</th>
                                <th>Website</th>
                                <th>Çıkış Tarihi</th>
                                <th>Yaş Sınırı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($games as $game)
                                @php
                                    $target                 = $game;
                                    $route                  = 'game';
                                    $delete_warning_message = '';
                                @endphp
                                <tr class="@if($game->status == 0) alert-danger @endif">
                                    <td class="font-weight-bold">
                                        {{ $game->id }}
                                    </td>
                                    <td>
                                        <img src="{{ $game->cover_image }}" alt="{{ $game->name }} Kapak Resmi" title="{{ $game->name }} Kapak Resmi" class="img-fluid rounded img-thumbnail" width="120" height="150">
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $game->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-category', [$game->category->id]) }}" class="text-primary text-decoration-none">{{ $game->category->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-developer', [$game->developer->id]) }}" class="text-primary text-decoration-none">{{ $game->developer->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-publisher', [$game->publisher->id]) }}" class="text-primary text-decoration-none">{{ $game->publisher->name }}</a>
                                    </td>
                                    <td>
                                        @php
                                            $game_platforms = $game->platforms->pluck('name' ,'id')->toArray();
                                        @endphp
                                        @foreach($game_platforms as $platform_id => $platform)
                                            <a href="{{ route('admin.edit-platform', $platform_id) }}" class="text-primary text-decoration-none">{{ $platform }}</a><br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $game_genres = $game->genres->pluck('name' ,'id')->toArray();
                                        @endphp
                                        @foreach($game_genres as $genre_id => $genre)
                                            <a href="{{ route('admin.edit-genre', $genre_id) }}" class="text-primary text-decoration-none">{{ $genre }}</a><br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ $game->details->website }}" class="text-primary text-decoration-none" target="_blank">{{ $game->name }}</a>
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($game->details->release_date)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <img src="{{asset('assets/pegi_ratings/pegi_') . $game->details->age_rating . '.png'}}" class="img-fluid" alt="{{ $game->details->age_rating }} yaş ve üzeri" width="30" height="30" title="{{ $game->details->age_rating }} yaş ve üzeri">
                                    </td>
                                    <td>
                                        @if($game->status == 1)
                                            <div class="mt-1">
                                                <a target="_blank" href="{{ route('game', [$game->slug]) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="fas fa-eye"></i></a>
                                            </div>
                                        @endif
                                        <div class="mt-1">
                                            <a href="{{ route('admin.edit-game', [$game->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-pen"></i></a>
                                        </div>
                                        <div class="mt-1">
                                            <a href="#" data-id="{{ $game->id }}" class="btn btn-danger btn-sm delete" data-toggle="modal" data-target="#delete{{ $target->slug }}Modal_{{ $target->id }}" data-tooltip="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash"></i></a>
                                        </div>
                                        <div class="mt-1">
                                            <input type="checkbox" data-id="{{ $game->id }}" class="status-switch" name="status" @if($game->status == 1) checked @endif data-toggle="toggle" data-size="sm" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </td>
                                </tr>
                                @include('backend.modals.deleteConfirmation')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-danger text-center">Oyun bulunamadı.</div>
                @endif
                @include('backend.modals.detailedGameSearch')
            </div>
        </div>
        <div id="dialog" class="d-none" title="Oyun Aktive Etme Hatası">
            <p class="dialog-content"></p>
        </div>
        {!! $games->withQueryString()->links() !!}
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
          $(function() {
             $('.status-switch').change(function() {
                var id    = $(this)[0].getAttribute('data-id');
                var state = $(this).prop('checked');

                 @foreach($games as $game)
                var game_id          = {{ $game->id }};
                var category_status  = {{ $game->category->status }};
                var developer_status = {{ $game->developer->status }};
                var publisher_status = {{ $game->publisher->status }};

                var initialize_dialog = function() {
                   $('#dialog').dialog({
                      resizable  : false,
                      dialogClass: 'no-close',
                      draggable  : false,
                      height     : 'auto',
                      width      : 'auto',
                      modal      : true,
                      show       : true,
                      hide       : true,
                      buttons    : [
                         {
                            text   : 'Tamam',
                            'class': 'btn btn-sm btn-secondary',
                            click  : function() {
                               $(this).dialog('close');
                               location.reload();
                            }
                         }
                      ]
                   });
                };

                if (game_id == id) {
                   if (category_status == 0) {
                      initialize_dialog();
                      $('.dialog-content').html('Oyunu aktive etmek için lütfen öncelikle <span class="text-primary font-weight-bold">kategorisini</span> aktive edin.');
                      $('#dialog').removeClass('d-none');
                   } else if (developer_status == 0) {
                      initialize_dialog();
                      $('.dialog-content').html('Oyunu aktive etmek için lütfen öncelikle <span class="text-primary font-weight-bold">geliştiricisini</span> aktive edin.');
                      $('#dialog').removeClass('d-none');
                   } else if (publisher_status == 0) {
                      initialize_dialog();
                      $('.dialog-content').html('Oyunu aktive etmek için lütfen öncelikle <span class="text-primary font-weight-bold">dağıtıcısını</span> aktive edin.');
                      $('#dialog').removeClass('d-none');
                   } else {
                      $.ajaxSetup({
                         headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                         },
                      });

                      $.ajax({
                         url     : "{{route('admin.switch-game-status') }}",
                         type    : 'POST',
                         dataType: 'json',
                         data    : {
                            state: state,
                            id   : id,
                         },
                         success : function(response) {
                            if (response.result) {
                               location.reload();
                            }
                         },
                         error   : function(xhr, status, error) {
                            console.log(xhr.responseText);
                            console.log(status);
                            console.log(error);
                         },
                      });
                   }
                }
                 @endforeach
             });

             $('#detailed-search-form').submit(function() {
                $("form#detailed-search-form :input").each(function(index, obj){
                   if ($(obj).val() == '') {
                      $(obj).remove();
                   }
                });
             });

             $('#query-form').submit(function() {
                $("form#query-form :input").each(function(index, obj){
                   if ($(obj).val() == '') {
                      $(obj).remove();
                   }
                });
             });

             $('#per-page').change(function() {
                $('#query-form').submit();
             });

             $('#reset-parameters').click(function() {
                window.location.href = "{{ route('admin.games') }}";
             });

             var url = window.location.href;
             if (url.includes('?')) {
                $('#reset-parameters').removeClass('d-none');
             } else {
                $('#reset-parameters').addClass('d-none');
             }

             var urlParams   = new URLSearchParams(window.location.search);
             var sort_column = urlParams.get('sort_by');
             var sort_dir    = urlParams.get('sort_dir');

             if (sort_dir == 'asc') {
                $('[data-column=\'' + sort_column + '\']').append('&nbsp;<i class="fa fa-arrow-down"></i>');
             } else {
                $('[data-column=\'' + sort_column + '\']').append('&nbsp;<i class="fa fa-arrow-up"></i>');
             }

             $('.sorter').css({'cursor': 'pointer'}).hover(
               function() { $(this).css('color', 'green'); },
               function() { $(this).css('color', 'white'); },
             ).click(function() {
                var column = $(this).attr('data-column');
                var dir    = "{{ $sort_dir }}";

                $('input[name="sort_by"]').val(column);
                $('input[name="sort_dir"]').val(dir);

                $('#query-form').submit();
             });
          });
       });
    </script>
@endsection
