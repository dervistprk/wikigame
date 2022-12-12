@extends('layouts.backend')
@section('title', 'Beyaz Liste')
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
            <a href="{{ route('admin.create-whitelist-user') }}" class="btn btn-sm btn-success" title="Ekle"><i
                        class="fas fa-plus"></i> Kullanıcı Ekle</a>
        </div>
        @if($errors->any())
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <div class="alert alert-danger m-2 text-center alert-dismissible fade show">
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
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-user-friends"></i>
                Beyaz Liste<i>(Panele Ulaşabilecek IP Adresi Listesi)</i>
                <div class="float-end">
                    <form class="form-inline" id="query-form" method="get"
                          action="{{ route('admin.whitelist-users') }}">
                        <input type="hidden" name="sort_by"/>
                        <input type="hidden" name="sort_dir"/>
                        <div class="m-2">
                            <label for="per-page" class="form-label">Öge Sayısı</label>
                            <select class="form-select" name="per_page" id="per-page">
                                @foreach(config('backend.per_page') as $config_per_page)
                                    <option value="{{ $config_per_page }}"
                                            @if($per_page == $config_per_page) selected @endif>{{ $config_per_page }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="m-2">
                            <label for="quick-search">Hızlı Ara</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $quick_search ?? null }}"
                                       name="quick_search" id="quick-search" placeholder="IP Adresi Ara"/>
                                <button class="btn btn-primary btn-sm mr-sm-2" id="btnNavbarSearch" type="submit">
                                    <i id="search-icon" class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="m-2 mt-4">
                            <button type="button" id="reset-parameters" class="btn btn-sm btn-warning d-none"
                                    data-toggle="tooltip" data-placement="top" title="Temizle">
                                <i class="fa fa-undo"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($white_list_users->items())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th class="sorter" data-column="id">ID</th>
                                <th class="sorter" data-column="ip">IP Adresi</th>
                                <th class="sorter" data-column="name">Ad</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($white_list_users as $user)
                                <tr @if($user->ip == request()->ip()) class="alert-info" @endif>
                                    <td class="font-weight-bold">
                                        {{ $user->id }}
                                    </td>
                                    <td>
                                        {{ $user->ip }}
                                    </td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        <div class="d-inline-block">
                                            <a href="{{ route('admin.edit-whitelist-user', $user->id) }}"
                                               class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top"
                                               title="Düzenle"><i class="fas fa-pen"></i></a>
                                        </div>
                                        <div class="d-inline-block" data-tooltip="tooltip" data-placement="top"
                                             @if($user->ip == request()->ip()) title="Bu IP adresinde aktif bir hesap giriş yapmış durumdadır."
                                             @else title="Sil" @endif>
                                            <a href="#" data-id="{{ $user->id }}"
                                               class="btn btn-danger btn-sm delete @if($user->ip == request()->ip()) disabled @endif">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-danger text-center">Beyaz listeye eklenmiş kullanıcı bulunamadı.</div>
                @endif
            </div>
        </div>
        {!! $white_list_users->withQueryString()->links() !!}
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
          $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
          });

          $(function() {
             $('#query-form').submit(function() {
                $('input').each(function(index, obj) {
                   if ($(obj).val() == '') {
                      $(obj).remove();
                   }
                });
             });

             $('#per-page').change(function() {
                $('#query-form').submit();
             });

             $('#reset-parameters').click(function() {
                window.location.href = "{{ route('admin.whitelist-users') }}";
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
                function() {
                   $(this).css('color', 'green');
                },
                function() {
                   $(this).css('color', 'white');
                },
             ).click(function() {
                var column = $(this).attr('data-column');
                var dir    = "{{ $sort_dir }}";

                $('input[name="sort_by"]').val(column);
                $('input[name="sort_dir"]').val(dir);

                $('#query-form').submit();
             });
          });

          $('.delete').on('click', function() {
             var confirm_text = 'IP Adresini Silmek İstediğinizden Emin misiniz?';
             var user_id      = $(this).data('id');
             if (confirm(confirm_text)) {
                $.ajax({
                   url     : "{{ route('admin.delete-whitelist-user') }}",
                   type    : 'POST',
                   dataType: 'json',
                   data    : {
                      user_id: user_id,
                   },
                   success : function() {
                      setTimeout(function() {
                         location.reload();
                      }, 2000);
                   },
                   error   : function(xhr, status, error) {
                      console.log(xhr.responseText);
                      console.log(status);
                      console.log(error);
                   }
                });
             }
          });
       });
    </script>
@endsection
