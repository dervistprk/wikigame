<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('redirect-js')
    <meta name="description" content="{{ $settings->meta_description }}"/>
    <meta name="author" content="WikiGame"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - WikiGame</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/bootstrap-4.4.1.css') }}">--}}
    {{--<link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>--}}
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{ asset('js/font-awesome-5.15.3.js') }}"></script>
{{--<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>--}}
{{--<script src="{{ asset('js/bootstrap-5.1.3-bundle.js') }}"></script>--}}
{{--<script src="{{ asset('js/bootstrap-4.4.1.js') }}"></script>--}}
{{--<script src="{{ asset('js/popper-1.12.9.js') }}"></script>--}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/dark-mode-switch.js') }}"></script>
<script src="{{ asset('js/lazysizes.min.js') }}"></script>
<script src="{{ asset('js/cookie-sent-3.min.js') }}"></script>
<script src="{{ asset('js/datepicker-tr.js') }}"></script>
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

    $('.search-input').typeahead({
        source     : function (request, response) {
            $.ajax({
                url     : "{{ route('autocompleteSearch') }}",
                type    : 'GET',
                dataType: 'JSON',
                data    : {query: $('.search-input').val()},
                beforeSend: function () {
                    $('#search-icon').removeClass('fa-paper-search').addClass('fa-spinner fa-spin');
                },
                success : function (data) {
                    response($.map(data, function (item) {
                        return {
                            url  : item.slug,
                            value: item.name
                        }
                    }))
                    $('#search-icon').removeClass('fa-spinner fa-spin').addClass('fa-search');
                }
            })
        },
        minLength  : 3,
        highlight  : true,
        displayText: function (item) {
            return item.value
        },
        updater    : function (event) {
            window.location.href = '/oyun/' + event.url;
        },
    });

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

</script>
@yield('custom-js')
</body>
</html>
