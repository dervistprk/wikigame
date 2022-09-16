@extends('layouts.backend')
@section('title', 'Kategoriler')
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
            <a href="{{ route('admin.create-category') }}" class="btn btn-sm btn-success" title="Ekle"><i class="fas fa-plus"></i> Kategori Ekle</a>
        </div>
        <div class="card mb-4 m-2 shadow">
            <div class="card-header font-weight-bold text-secondary">
                <i class="fas fa-bookmark"></i>
                Kayıtlı Kategoriler
                <div class="float-end">
                    <form class="form-inline" id="query-form" method="get" action="{{ route('admin.categories') }}">
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
                                <input type="text" class="form-control" value="{{ $quick_search ?? null }}" name="quick_search" id="quick-search" placeholder="Kategori Ara"/>
                                <button class="btn btn-primary btn-sm mr-sm-2" id="btnNavbarSearch" type="submit">
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
                @if($categories->items())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th><input type="checkbox" class="form-check" id="check-all"></th>
                                <th class="sorter" data-column="id">ID</th>
                                <th class="sorter" data-column="name">Adı</th>
                                <th>Açıklama</th>
                                <th>Oyun Sayısı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                @php
                                    $title  = 'Kategori';
                                    $plural = 'kategorileri';
                                    $target = $category;
                                    $route  = 'category';
                                    $category->games->count() > 0 ? $delete_warning_message = '<div class="alert alert-danger mt-2"><div class="text-center"><i class="fa fa fa-exclamation-triangle"></i></div><div>Bu kategoriyi silerseniz, kategoriye bağlı <strong>oyunlar</strong> da silinecektir.</div></div>' : $delete_warning_message = '';
                                @endphp
                                <tr class="@if($category->status == 0) alert-danger @endif">
                                    <td>
                                        <input type="checkbox" class="form-check delete-check" data-id="{{ $category->id }}">
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $category->id }}
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $category->name }}
                                    </td>
                                    <td>{!! trim(strip_tags(Str::limit($category->description, '1000'))) !!}  </td>
                                    <td class="font-weight-bold">
                                        {{ $category->games()->active()->count() }}
                                    </td>
                                    <td>
                                        @if($category->status == 1)
                                            <div class="mt-1">
                                                <a target="_blank" href="{{ route('category', [$category->slug]) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="fas fa-eye"></i></a>
                                            </div>
                                        @endif
                                        <div class="mt-1">
                                            <a href="{{ route('admin.edit-category', [$category->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-pen"></i></a>
                                        </div>
                                        <div class="mt-1">
                                            <a href="#" data-id="{{ $category->id }}" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$target->slug}}Modal_{{$target->id}}" data-tooltip="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash"></i></a>
                                        </div>
                                        <div class="mt-1">
                                            <input type="checkbox" data-id="{{ $category->id }}" class="status-switch" name="status" @if($category->status == 1) checked @endif data-toggle="toggle" data-size="sm" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </td>
                                </tr>
                                @include('backend.modals.deleteConfirmation')
                            @endforeach
                            @include('backend.modals.statusDialog')
                            @include('backend.modals.multipleDelete')
                            </tbody>
                        </table>
                        <div class="row col-sm-2 justify-content-center" id="multiple-destroy-overlay" data-toggle="tooltip" data-placement="top" title="Silinecek öge seçin">
                            <a class="btn btn-danger btn-sm text-white" id="multiple-destroy" data-toggle="modal" data-target="#delete-multiple-modal"><i class="fas fa-trash-alt"></i> Seçilenleri Sil</a>
                        </div>
                    </div>
                @else
                    <div class="text-danger text-center">Kategori bulunamadı.</div>
                @endif
            </div>
        </div>
        {!! $categories->withQueryString()->links() !!}
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

          $(function() {
             $('.status-switch').change(function() {
                var id    = $(this)[0].getAttribute('data-id');
                var state = $(this).prop('checked');

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
                                  url     : "{{ route('admin.switch-category-status') }}",
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
                      url     : "{{ route('admin.switch-category-status') }}",
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
                window.location.href = "{{ route('admin.categories') }}";
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

          var delete_array = [];
          $('#multiple-destroy').addClass('disabled');
          $('#multiple-destroy').css('pointer-events', 'none');

          $('#check-all').click(function() {
             $('.delete-check').prop('checked', this.checked);
             if ($(this).is(':checked')) {
                $('.delete-check').each(function() {
                   delete_array.push($(this).attr('data-id'));
                });
                delete_array = delete_array.filter(function(element, index, self) {
                   return index === self.indexOf(element);
                });
                $('#multiple-destroy').removeClass('disabled');
                $('#multiple-destroy').css('pointer-events', 'auto');
                $('#multiple-destroy-overlay').tooltip('disable');
             } else {
                delete_array.splice(0, delete_array.length);
                $('#multiple-destroy').addClass('disabled');
                $('#multiple-destroy').css('pointer-events', 'none');
                $('#multiple-destroy-overlay').tooltip('enable');
             }
          });

          $('.delete-check').change(function() {
             if ($(this).is(':checked')) {
                delete_array.push($(this).attr('data-id'));
             } else {
                var found;
                var remove_item = $(this).attr('data-id');
                while ((found = $.inArray(remove_item, delete_array)) !== -1) {
                   delete_array.splice(found, 1);
                }
             }

             if ($('.delete-check:checked').length == $('.delete-check').length) {
                $('#check-all').prop('checked', true);
             } else {
                $('#check-all').prop('checked', false);
             }

             if (delete_array.length === 0) {
                $('#multiple-destroy').addClass('disabled');
                $('#multiple-destroy').css('pointer-events', 'none');
                $('#multiple-destroy-overlay').tooltip('enable');
             } else {
                $('#multiple-destroy').removeClass('disabled');
                $('#multiple-destroy').css('pointer-events', 'auto');
                $('#multiple-destroy-overlay').tooltip('disable');
             }
          });

          $('#multiple-destroy-button').click(function() {
             $.ajax({
                url       : "{{ route('admin.delete-multiple-category') }}",
                type      : 'POST',
                dataType  : 'json',
                data      : {
                   ids: delete_array,
                },
                beforeSend: function() {
                   $('#delete-loading-icon').removeClass('d-none');
                },
                success   : function() {
                   $('#multiple-delete-message').removeClass('d-none');
                   setTimeout(function() {
                      $(location).prop('href', '{{ route('admin.categories') }}');
                   }, 2000);
                },
                error     : function(xhr, status, error) {
                   console.log(xhr.responseText);
                   console.log(status);
                   console.log(error);
                }
             });
          });
       });
    </script>
@endsection