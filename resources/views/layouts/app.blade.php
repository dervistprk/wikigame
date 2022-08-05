<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    @yield('redirect-js')
    <meta name="description" content="{{ $settings->meta_description }}"/>
    <meta name="author" content="WikiGame"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - WikiGame</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-4.4.1.css') }}">
    <script src="{{ asset('js/font-awesome-5.15.3.js') }}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cookie-sent-3.min.css') }}"/>
    @yield('custom-css')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KY0WRBH1EE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-KY0WRBH1EE');
    </script>
</head>
<body>
@include('layouts.header')
@yield('content')
<button class="btn btn-warning rounded-circle" onclick="topFunction()" id="topBtn" data-toggle="tooltip" data-placement="top" title="En Üste Git"><i class="fas fa-angle-up"></i></button>
@include('layouts.footer')
<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('js/bootstrap-5.1.3-bundle.js') }}"></script>
<script src="{{ asset('js/bootstrap-4.4.1.js') }}"></script>
<script src="{{ asset('js/popper-1.12.9.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/dark-mode-switch.js') }}"></script>
<script src="{{ asset('js/lazysizes.min.js') }}"></script>
<script src="{{ asset('js/cookie-sent-3.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#000"
            },
            "button": {
                "background": "#f1d600"
            }
        },
        "theme": "classic",
        "position": "bottom-left",
        "content": {
            "message": "Bu websitesi, sitemizden en iyi şekilde yararlandığınızdan emin olmak için çerezler kullanır.",
            "dismiss": "Anladım",
            "link": "Daha Fazla Bilgi"
        }
    });

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
@yield('custom-js')
</body>
</html>
