@extends('layouts.backend')
@section('title', 'Kullanıcılar')
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
                <i class="fas fa-newspaper"></i>
                Kayıtlı Kullanıcılar
                <div class="float-end">
                    <form class="form-inline" id="query-form" method="get" action="{{ route('admin.user-operations') }}">
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
                                <input type="text" class="form-control" value="{{ $quick_search ?? null }}" name="quick_search" id="quick-search" placeholder="Kullanıcı Ara"/>
                                <button class="btn btn-primary btn-sm mr-sm-2" id="btnNavbarSearch" type="submit">
                                    <i id="search-icon" class="fas fa-search"></i>
                                </button>
                            </div>
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
                @if($users->items())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th class="sorter" data-column="id">ID</th>
                                <th class="sorter" data-column="email">E-Posta</th>
                                <th class="sorter" data-column="user_name">Kullanıcı Adı</th>
                                <th class="sorter" data-column="name">Adı</th>
                                <th class="sorter" data-column="surname">Soyadı</th>
                                <th>Onaylanmış</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="@if($user->isBanned()) alert-danger @endif">
                                    <td class="font-weight-bold">
                                        {{ $user->id }}
                                    </td>
                                    <td>
                                        @if($user->isAdmin())
                                            <div class="badge badge-secondary">Yönetici</div>
                                        @endif
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->user_name }}
                                    </td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->surname }}
                                    </td>
                                    <td class="text-center">
                                        @if($user->isVerified())
                                            <i class="fas fa-check-circle fa-2x" style="color: limegreen"></i>
                                        @else
                                            <i class="fas fa-times fa-2x" style="color: red"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$user->isBanned())
                                            @if($user->isAdmin())
                                                <div class="d-inline-block" data-toggle="tooltip" data-placement="top" title="Yöneticiler Yasaklanamaz">
                                                    <a href="#" class="btn btn-sm btn-danger disabled"><i class="fas fa-user-slash"></i></a>
                                                </div>
                                            @else
                                                <div class="d-inline-block">
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#user-ban-modal-{{ $user->id }}" data-tooltip="tooltip" data-placement="top" title="Yasakla"><i class="fas fa-user-slash"></i></a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-inline-block">
                                                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#remove-user-ban-modal-{{ $user->id }}" data-tooltip="tooltip" data-placement="top" title="Yasak Kaldır"><i class="fas fa-user-check"></i></a>
                                            </div>
                                        @endif
                                        <div class="d-inline-block">
                                            <a href="{{ route('admin.user-comments', $user->id) }}" class="btn btn-sm btn-primary" data-tooltip="tooltip" data-placement="top" title="Kullanıcı Yorumları"><i class="fas fa-comment"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @include('backend.modals.userBanModal')
                                @include('backend.modals.removeUserBan')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-danger text-center">Kullanıcı bulunamadı.</div>
                @endif
            </div>
        </div>
        {!! $users->withQueryString()->links() !!}
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
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
                window.location.href = "{{ route('admin.user-operations') }}";
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

          $('.user-ban-modal').modal('handleUpdate');

          $('.remove-ban').click(function() {
             var user_id = $(this).attr('data-id');

             $.ajaxSetup({
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
             });

             $.ajax({
                url     : "{{ route('admin.remove-user-ban') }}",
                type    : 'post',
                dataType: 'json',
                data    : {
                   user_id: user_id,
                },
                success : function() {
                   $('.user-ban-remove-message').removeClass('d-none');
                   setTimeout(function() {
                      location.reload();
                   }, 2000);
                },
                error   : function(xhr, status, error) {
                   console.log(xhr.responseText);
                   console.log(status);
                   console.log(error);
                },
             });
          });
       });
    </script>
@endsection
