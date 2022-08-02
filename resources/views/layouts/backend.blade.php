<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="{{ $settings->meta_description }}"/>
    <meta name="author" content="dervis"/>
    <title>@yield('title') - WikiGame</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->backend_favicon) }}"/>
    <link href="{{ asset('backend/css/simple-datatables.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-4.3.1.css') }}">
    <link href="{{ asset('backend/css/summernote-0.9.18-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/backend.css') }}" rel="stylesheet"/>
    <script src="{{ asset('js/font-awesome-5.15.3.js') }}"></script>
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
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user-circle"></i> Profil</a></li>
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
                    <a class="nav-link @if(Request::segment(2) == 'yonetim') active @endif" href="{{ route('admin.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Yönetim Paneli
                    </a>
                    <a class="nav-link @if(Request::segment(2) == 'kategoriler') active @endif" href="{{ route('admin.categories') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                        Kategoriler
                    </a>
                    <a class="nav-link @if(Request::segment(2) == 'oyunlar') active @endif" href="{{ route('admin.games') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-gamepad"></i></div>
                        Oyunlar
                    </a>
                    <a class="nav-link @if(Request::segment(2) == 'gelistiriciler') active @endif" href="{{ route('admin.developers') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-calculator"></i></div>
                        Geliştiriciler
                    </a>
                    <a class="nav-link @if(Request::segment(2) == 'dagiticilar') active @endif" href="{{ route('admin.publishers') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                        Dağıtıcılar
                    </a>
                    <a class="nav-link @if(Request::segment(2) == 'makaleler') active @endif" href="{{ route('admin.articles') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Makaleler
                    </a>
                    <a class="nav-link @if(Request::segment(2) == 'ayarlar') active @endif" href="{{ route('admin.settings') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                        Ayarlar
                    </a>
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
<script src="{{ asset('backend/js/jquery-3.3.1-slim.js') }}"></script>
<script src="{{ asset('backend/js/popper-1.14.7.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap-4.3.1.js') }}"></script>
<script src="{{ asset('js/bootstrap-5.1.3-bundle.js') }}"></script>
<script src="{{ asset('backend/js/scripts.js') }}"></script>
<script src="{{ asset('backend/js/chart-2.8.0.js') }}"></script>
<script src="{{ asset('backend/js/simple-datatables.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('backend/js/datatables-simple-demo.js') }}"></script>
<script src="{{ asset('backend/js/summernote-0.8.18-bs4.js') }}"></script>
<script src="{{ asset('backend/js/summernote-0.8.18-tr.js') }}"></script>
<script>
    $(document).ready(function () {
        $('textarea').summernote({
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
                    ['actions', ['undo', 'redo', 'fullscreen']],
                ],
                fontSizes: ['7', '8', '9', '10', '11', '12', '14','16', '18', '20', '22', '24', '26', '28', '30', '32', '34', '36', '48'],
                height: 400,
                focus: false,
                placeholder: 'Açıklama Giriniz',
                dialogsFade: true,
                lang: 'tr-TR'
            }
        );
    });
</script>
@yield('custom-js')
</body>
</html>
