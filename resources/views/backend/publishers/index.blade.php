@extends('layouts.backend')
@section('title', 'Dağıtıcılar')
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
            <a href="{{route('admin.create-publisher')}}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus" style="margin-top: 3px;"></i> Dağıtıcı Ekle</a>
        </div>
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-newspaper"></i>
                Kayıtlı Dağıtıcılar
                <div class="float-end">
                    <form class="form-inline" id="query-form" method="get" action="{{ route('admin.publishers') }}">
                        <input type="hidden" name="sort_by"/>
                        <input type="hidden" name="sort_dir"/>
                        <div class="m-2">
                            <label for="per-page" class="form-label">Öge Sayısı</label>
                            <select class="form-select" name="per_page" id="per-page">
                                <option value="10" @if($per_page == 10) selected @endif>10</option>
                                <option value="20" @if($per_page == 20) selected @endif>20</option>
                                <option value="30" @if($per_page == 30) selected @endif>30</option>
                                <option value="40" @if($per_page == 40) selected @endif>40</option>
                                <option value="50" @if($per_page == 50) selected @endif>50</option>
                            </select>
                        </div>
                        <div class="m-2">
                            <label for="quick-search">Hızlı Ara</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $quick_search ?? null }}" name="quick_search" id="quick-search" placeholder="Dağıtıcı Ara"/>
                                <button class="btn btn-primary btn-sm mr-sm-2" id="btnNavbarSearch" type="submit">
                                    <i id="search-icon" class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="m-2 mt-4">
                            <button type="button" id="reset-parameters" class="btn btn-sm btn-warning d-none" data-toggle="tooltip" data-placement="top" title="Temizle">
                                <i class="fa fa-undo"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($publishers->items())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Dağıtıcı Logosu</th>
                                <th class="sorter" data-column="name">Adı</th>
                                <th>Oyun Sayısı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($publishers as $publisher)
                                @php
                                    $title  = 'Dağıtıcı';
                                    $target = $publisher;
                                    $route  = 'publisher';
                                    $publisher->games->count() > 0 ? $delete_warning_message = '<div class="alert alert-danger mt-2"><div class="text-center"><i class="fa fa fa-exclamation-triangle"></i></div><div>Bu dağıtıcıyı silerseniz, dağıtıcıya bağlı <strong>oyunlar</strong> da silinecektir.</div></div>' : $delete_warning_message = '';
                                @endphp
                                <tr class="@if($publisher->status == 0) alert-danger @endif">
                                    <td>
                                        <img src="{{ $publisher->image }}" alt="geliştirici resmi" class="img-fluid img-thumbnail" title="{{ $publisher->name }}" width="200" height="150">
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $publisher->name }}
                                    </td>
                                    <td class="font-weight-bold">{{ $publisher->games->count() }}</td>
                                    <td>
                                        @if($publisher->status == 1)
                                            <div class="mt-1">
                                                <a target="_blank" href="{{ route('publisher', [$publisher->slug]) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="fas fa-eye"></i></a>
                                            </div>
                                        @endif
                                        <div class="mt-1">
                                            <a href="{{ route('admin.edit-publisher', [$publisher->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-pen"></i></a>
                                        </div>
                                        <div class="mt-1">
                                            <a href="#" data-id="{{ $publisher->id }}" class="btn btn-sm btn-danger delete" data-toggle="modal" data-target="#delete{{$target->slug}}Modal_{{$target->id}}" data-tooltip="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash"></i></a>
                                        </div>
                                        <div class="mt-1">
                                            <input type="checkbox" data-id="{{ $publisher->id }}" class="status-switch" name="status" @if($publisher->status == 1) checked @endif data-toggle="toggle" data-on="Aktif" data-size="sm" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </td>
                                </tr>
                                @include('backend.modals.deleteConfirmation')
                            @endforeach
                            @include('backend.modals.statusDialog')
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-danger text-center">Aranan kriterlere uygun dağıtıcı bulunamadı.</div>
                @endif
            </div>
        </div>
        {!! $publishers->withQueryString()->links() !!}
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
          $(function() {
             $('.status-switch').change(function() {
                var id    = $(this)[0].getAttribute('data-id');
                var state = $(this).prop('checked');

                $.ajaxSetup({
                   headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                   },
                });

                if (!state) {
                   $('#dialog-confirm').removeClass('d-none');
                   $('#dialog-confirm').dialog({
                      resizable  : false,
                      dialogClass: 'no-close',
                      height     : 'auto',
                      width      : 'auto',
                      draggable  : false,
                      modal      : true,
                      show       : true,
                      hide       : true,
                      buttons    : [
                         {
                            text   : 'Devam Et',
                            'class': 'btn btn-sm btn-primary',
                            click  : function() {
                               $.ajax({
                                  url     : "{{ route('admin.switch-publisher-status') }}",
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
                            }
                         },
                         {
                            text   : 'İptal',
                            'class': 'btn btn-sm btn-secondary',
                            click  : function() {
                               $(this).dialog('close');
                               location.reload();
                            }
                         }
                      ]
                   });
                } else {
                   $.ajax({
                      url     : "{{route('admin.switch-publisher-status') }}",
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
                }
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
                window.location.href = "{{ route('admin.publishers') }}";
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
