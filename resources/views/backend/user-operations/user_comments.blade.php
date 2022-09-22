@extends('layouts.backend')
@section('title', 'Kullanıcı Yorumları')
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
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-laptop"></i>
                Kullanıcı Yorumları <span class="font-weight-bolder">[{{ $user->name . ' ' . $user->surname }}]</span>
                <div class="float-end">
                    <form class="form-inline" id="query-form" method="get" action="{{ route('admin.user-comments', $user->id) }}">
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
                                <input type="text" class="form-control" value="{{ $quick_search ?? null }}" name="quick_search" id="quick-search" placeholder="Yorum Ara"/>
                                <button class="btn btn-primary mr-sm-2" id="btnNavbarSearch" type="submit">
                                    <i id="search-icon" class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="m-2 mt-4">
                            <button type="button" id="reset-parameters" class="btn btn-sm btn-warning d-none" data-toggle="tooltip" data-placement="top" title="Temizle">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($user->comments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th class="sorter" data-column="id">ID</th>
                                <th>Yorum Yapılan İçerik</th>
                                <th class="sorter" data-column="body">Yorum İçeriği</th>
                                <th class="sorter" data-column="likes">Beğenilme Sayısı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr class="@if($comment->is_verified == 0) alert-danger @endif">
                                    <td class="font-weight-bold">
                                        {{ $comment->id }}
                                    </td>
                                    <td class="font-weight-bold">
                                        @php
                                            $content = $comment->commentable_type::findOrFail($comment->commentable_id);
                                        @endphp
                                        {{ $content->name ?: $content->title }}
                                    </td>
                                    <td class="font-weight-bold">
                                        {!! $comment->body !!}
                                    </td>
                                    <td>
                                        {{ $comment->likes }}
                                    </td>
                                    <td>
                                        <div class="d-inline-block">
                                            <a class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#user-comment-edit-modal-{{ $comment->id }}" data-tooltip="tooltip" data-placement="top" title="Yorumu Düzenle"><i class="fas fa-pen"></i></a>
                                        </div>
                                        <div class="d-inline-block">
                                            <input type="checkbox" data-id="{{ $comment->id }}" class="status-switch" name="status" @if($comment->is_verified == 1) checked @endif data-toggle="toggle" data-size="sm" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </td>
                                </tr>
                                @include('backend.modals.userCommentEdit')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-danger text-center">Kullanıcı yorumu bulunamadı.</div>
                @endif
            </div>
        </div>
        {!! $comments->withQueryString()->links() !!}
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
           $.ajaxSetup({
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
           });

           $('.status-switch').change(function() {
              var id    = $(this)[0].getAttribute('data-id');
              var state = $(this).prop('checked');

              $.ajax({
                 url     : "{{ route('admin.verify-user-comment') }}",
                 type    : 'POST',
                 dataType: 'json',
                 data    : {
                    state: state,
                    id   : id,
                 },
                 success : function() {
                    location.reload();
                 },
                 error   : function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                 },
              });
           });

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
              window.location.href = "{{ route('admin.user-comments', $user->id) }}";
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
    </script>
@endsection