<div class="fixed-top" data-toggle="affix">
    <nav class="navbar navbar-expand-xl navbar-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(($settings->logo))
                    <img src="{{ $settings->logo }}" alt="Site Logo" width="40" height="40" title="Wikigame">
                @endif WikiGame
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach(trans('navbar.menus') as $menu)
                        <li class="nav-item text-nowrap">
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
                               data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="fas fa-user-circle"></i> {{ __('Üyelik') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('register-form') }}">
                                        <i class="fas fa-user-plus"></i> {{ __('Üye Ol') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('login-form') }}">
                                        <i class="fas fa-sign-in-alt"></i> {{ __('Giriş Yap') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('resend-verification') }}">
                                        <i class="fas fa-envelope"></i> {{ __('Doğrulama Postası') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle categories-drop-down" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="fas fa-user-circle"></i> {{ __('Üyelik') }}</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-profile') }}">
                                        <i class="fas fa-user-circle"></i> {{ __('Profilim') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-logout') }}">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Çıkış Yap') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @include('frontend.lang_switcher')
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
                <div class="search-bar">
                    <form class="form-inline search-form" action="{{ route('search') }}" method="get">
                        @csrf
                        <div class="input-group">
                            <input class="form-control search-input" type="text" autocomplete="off"
                                   placeholder="{{ __('Aramak İstediğiniz Kelimeyi Yazın') }}" aria-label="Search"
                                   aria-describedby="btnNavbarSearch" name="search"
                                   value="{{ request()->query('search') }}"/>
                            <button class="btn btn-primary mr-sm-2" id="btnNavbarSearch" type="submit">
                                <i id="search-icon" class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav">
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link @if(Request::segment(2) == $category->slug) active @endif text-nowrap"
                               href="{{ route('category', [$category->slug]) }}">{{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'tum-oyunlar') active @endif text-nowrap"
                           href="{{ route('all-games') }}"><i class="fa fa-gamepad"></i> {{ __('Tüm Oyunlar') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
