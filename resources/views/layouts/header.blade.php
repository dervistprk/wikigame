<div class="fixed-top" data-toggle="affix">
    <nav class="navbar navbar-expand-xl navbar-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(($settings->logo))
                    <img src="{{ $settings->logo }}" alt="Site Logo" width="40" height="40" title="Wikigame">
                @endif WikiGame</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach(config('frontend.menus') as $menu)
                        <li class="nav-item">
                            <a class="nav-link @if(Request::segment(1) == $menu['segment']) active @endif"
                               aria-current="page" href="{{ route($menu['route']) }}"><i
                                        class="fas fa-{{ $menu['icon'] }}"></i>
                                {{ $menu['title'] }}
                            </a>
                        </li>
                    @endforeach
                    @if(Auth::guest())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle categories-drop-down" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-circle"></i> Üyelik</a>
                            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('register-form') }}"><i
                                                class="fas fa-user-plus"></i> Üye Ol</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('login-form') }}"><i
                                                class="fas fa-sign-in-alt"></i> Giriş Yap</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('resend-verification') }}"><i
                                                class="fas fa-envelope"></i> Doğrulama Postası</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle categories-drop-down" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-circle"></i> Üyelik</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-profile') }}"><i
                                                class="fas fa-user-circle"></i> Profilim</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-logout') }}"><i
                                                class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <div class="form-check form-switch me-3 mt-2">
                        <i class="fas fa-sun"></i>
                        <input type="checkbox" class="form-check-input" role="switch" id="darkSwitch">
                        <i class="fas fa-moon"></i>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Second Navbar -->
    <nav class="navbar navbar-expand-xl navbar-dark" id="navbar2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                <form class="form-inline" action="{{ route('search') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input class="form-control search-input" type="text" autocomplete="off"
                               placeholder="Aramak İstediğiniz Oyun Adını Yazın" aria-label="Ara..."
                               aria-describedby="btnNavbarSearch" name="search"/>
                        <button class="btn btn-primary mr-sm-2" id="btnNavbarSearch" type="submit">
                            <i id="search-icon" class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <ul class="navbar-nav ms-3">
                    @foreach($categories as $category)
                        <li class="nav-item ms-3">
                            <a class="nav-link @if(Request::segment(2) == $category->slug) active @endif"
                               href="{{ route('category', [$category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item ms-3">
                        <a class="nav-link @if(Request::segment(1) == 'tum-oyunlar') active @endif"
                           href="{{ route('all-games') }}"><i class="fa fa-gamepad"></i> Tüm Oyunlar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
