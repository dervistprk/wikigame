<div class="fixed-top" data-toggle="affix">
    <nav class="navbar navbar-expand-xl navbar-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(($settings->logo))
                    <img src="{{ $settings->logo }}" alt="Site Logo" width="40" height="40" title="Wikigame">
                @endif WikiGame</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == '') active @endif" aria-current="page" href="{{ route('home') }}"><i class="fas fa-home"></i> Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('random-game') }}"><i class="fas fa-random"></i> Rastgele Oyun</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'gelistiriciler') active @endif" href="{{ route('developers') }}"><i class="fas fa-calculator"></i> Geliştiriciler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'dagiticilar') active @endif" href="{{ route('publishers') }}"><i class="fas fa-newspaper"></i> Dağıtıcılar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'makaleler') active @endif" href="{{ route('articles') }}"><i class="fas fa-book-open"></i> Makaleler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'hakkinda') active @endif" href="{{ route('about') }}"><i class="fas fa-book"></i> Hakkında</a>
                    </li>
                    @if(Auth::guest())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle categories-drop-down" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-circle"></i> Üyelik</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('register-form') }}"><i class="fas fa-user"></i> Üye Ol</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('login-form') }}"><i class="fas fa-door-open"></i> Giriş Yap</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('resend-verification') }}"><i class="fas fa-paper-plane"></i> Doğrulama Postası Gönder</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle categories-drop-down" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-circle"></i> Üyelik</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-profile') }}"><i class="fas fa-user-circle"></i> Profilim</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user-logout') }}"><i class="fas fa-door-closed"></i> Çıkış Yap</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item">
                        <div class="custom-control custom-switch me-3 mt-2">
                            <span style="margin-right: 50px;"><i class="fas fa-sun"></i></span>
                            <input type="checkbox" class="custom-control-input" id="darkSwitch">
                            <label class="custom-control-label p-1" for="darkSwitch"></label>
                            <i class="fas fa-moon"></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<!-- Second Navbar -->
    <nav class="navbar navbar-expand-xl navbar-dark" id="navbar2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                <form class="form-inline" action="{{ route('search') }}" method="post">
                    @csrf
                    <div class="input-group w-100 m-1 ms-3 me-3">
                        <input class="form-control search-input" type="text" autocomplete="off" placeholder="Aramak İstediğiniz Oyun Adını Yazın" aria-label="Ara..." aria-describedby="btnNavbarSearch" name="search"/>
                        <button class="btn btn-primary mr-sm-2" id="btnNavbarSearch" type="submit">
                            <i id="search-icon" class="fas fa-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav ms-3">
                    @foreach($categories as $category)
                    <li class="nav-item me-2">
                        <a class="nav-link @if(Request::segment(2) == $category->slug) active @endif" href="{{ route('category', [$category->slug]) }}">{{ $category->name }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'tum-oyunlar') active @endif" href="{{ route('all-games') }}"><i class="fa fa-gamepad"></i> Tüm Oyunlar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
