<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="noindex,nofollow"/>
    <meta name="description" content="{{ $settings->meta_description }}"/>
    <meta name="author" content="WikiGame"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title') - WikiGame</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->backend_favicon) }}"/>
    <link href="{{ asset('backend/css/bootstrap-4.3.1.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/backend.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/jquery-ui-blitzer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/toggle-bs4.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/select2.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/select2-bs5.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/file-input.css') }}" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous"/>
    @yield('custom-css')
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">WikiGame</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i> {{ \Auth::user()->name . ' ' . \Auth::user()->surname}}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user-circle"></i> Profil</a>
                </li>
                <li>
                    <hr class="dropdown-divider"/>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fas fa-door-closed"></i> Çıkış</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Navbar-->
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    @foreach(config('backend.menus') as $menu)
                        <a class="nav-link @if(Request::segment(2) == $menu['segment']) active @endif" href="{{ route('admin.' . $menu['route']) }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-{{ $menu['icon'] }}"></i></div>
                            {{ $menu['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="sb-sidenav-footer">
                WikiGame Admin Paneli
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        @yield('content')
        <footer class="py-3 bg-dark mt-auto">
            <div class="container-fluid px-3">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Tüm Hakları Saklıdır &copy; WikiGame {{ \Illuminate\Support\Carbon::now()->format('Y') }}</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="{{ asset('js/jquery-3.5.1.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/popper-1.14.7.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/bootstrap-4.3.1.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-5.1.3-bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/font-awesome-5.15.3.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/jquery-ui.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/bs-toggle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/select2-tr.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/file-input.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/file-input-fa5.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/file-input-tr.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/scripts.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/summernote-0.8.18-bs4.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/summernote-0.8.18-tr.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datepicker-tr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function() {
      $(function() {
         $('[data-toggle="tooltip"]').tooltip();
         $('[data-tooltip="tooltip"]').tooltip();
      });

      $('textarea').summernote({
           toolbar    : [
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
              ['actions', ['undo', 'redo', 'fullscreen']],
           ],
           fontSizes  : ['7', '8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36', '48'],
           height     : 400,
           focus      : false,
           placeholder: 'Açıklama Giriniz',
           dialogsFade: true,
           lang       : 'tr-TR'
        }
      );

      $('.date-picker').datepicker({
         changeMonth: true,
         changeYear : true,
         showAnim   : 'slideDown',
         dateFormat : 'yy-mm-dd',
         yearRange  : '1900:' + new Date().getFullYear(),
         maxDate    : '+0D'
      });

      $('.date-picker').attr('readonly', true).css({
         'cursor': 'pointer'
      });

      $('.select2').select2({
         theme      : 'bootstrap-5',
         placeholder: 'Lütfen Seçin',
         language   : 'tr'
      });

      (function() {
         'use strict';
         window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
               form.addEventListener('submit', function(event) {
                  if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();
                  }
                  form.classList.add('was-validated');
               }, false);
            });
         }, false);
      })();

      $('input[type="file"]').fileinput({
         language                : 'tr',
         showUpload              : false,
         previewFileType         : 'any',
         browseOnZoneClick       : true,
         removeClass             : 'btn btn-danger',
         previewZoomButtonClasses: {
            close: 'btn btn-sm btn-outline-danger ms-1',
         },
         maxFileSize             : 3092,
         allowedFileExtensions   : ['jpg', 'jpeg', 'webp', 'png', 'svg']
      });

      $(document).on('focus', '.upload-other-images', function() {
         $(this).fileinput({
            language                : 'tr',
            showUpload              : false,
            previewFileType         : 'any',
            browseOnZoneClick       : true,
            removeClass             : 'btn btn-danger',
            previewZoomButtonClasses: {
               close: 'btn btn-sm btn-outline-danger ms-1',
            },
            maxFileSize             : 3092,
            allowedFileExtensions   : ['jpg', 'jpeg', 'webp', 'png', 'svg']
         });
      });
   });
</script>
@yield('custom-js')
</body>
</html>
