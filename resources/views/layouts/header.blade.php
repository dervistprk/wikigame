<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if(($settings->logo))
                <img src="{{ $settings->logo }}" alt="Site Logo" width="40" height="40" title="Wikigame">
            @endif WikiGame</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="{{ route('search') }}" method="post">
                @csrf
                <div class="input-group">
                    <input class="form-control search-input" type="text" autocomplete="off" placeholder="Oyun Adını Yazın.." aria-label="Ara..." aria-describedby="btnNavbarSearch" name="search"/>
                    <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i id="search-icon" class="fas fa-search"></i></button>
                </div>
            </form>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle categories-drop-down" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bookmark"></i> Kategoriler</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('category', [$category->slug]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                        <li>
                            <hr class="dropdown-divider"/>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('all-games') }}"><i class="fa fa-gamepad"></i> Tüm Oyunlar</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::segment(1) == 'makaleler') active @endif" href="{{ route('articles') }}"><i class="fas fa-book-open"></i> Makaleler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::segment(1) == 'hakkinda') active @endif" href="{{ route('about') }}"><i class="fas fa-book"></i> Hakkında</a>
                </li>
            </ul>
        </div>
        <div class="custom-control custom-switch">
            <span style="margin-right: 50px;"><i class="fas fa-sun"></i></span>
            <input type="checkbox" class="custom-control-input" id="darkSwitch">
            <label class="custom-control-label p-1" for="darkSwitch"></label>
            <i class="fas fa-moon"></i>
        </div>
    </div>
</nav>

@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        var route = "{{ route('autocompleteSearch') }}";
        $('.search-input').typeahead({
            minLength: 3,
            highlight: true,
            source   : function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            },
        });
    </script>
@endsection