<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    @yield('redirect-js')
    <meta name="description" content="{{ $settings->meta_description }}"/>
    <meta name="author" content="WikiGame"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title') - WikiGame</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}"/>
    <link href="{{ asset('css/bootstrap-5.1.3.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/jquery-ui-blitzer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/cookie-sent-3.min.css') }}" rel="stylesheet"/>
    @yield('custom-css')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KY0WRBH1EE"></script>
    <script>
       window.dataLayer = window.dataLayer || [];

       function gtag() {dataLayer.push(arguments);}

       gtag('js', new Date());
       gtag('config', 'G-KY0WRBH1EE');
    </script>
</head>
<body>
@include('layouts.header')
@yield('content')
<button class="btn btn-warning rounded-circle" onclick="topFunction()" id="topBtn" data-toggle="tooltip" data-placement="top" title="En Üste Git">
    <i class="fas fa-angle-up"></i>
</button>
@include('layouts.footer')
<script src="{{ asset('js/jquery-3.6.1.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-5.1.3-bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/font-awesome-5.15.3.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/jquery-ui.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/scripts.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dark-mode-switch.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lazysizes.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/cookie-sent-3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datepicker-tr.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/typeahead.js') }}" type="text/javascript"></script>
<script type="text/javascript">
   window.cookieconsent.initialise({
      'palette' : {
         'popup' : {
            'background': '#000'
         },
         'button': {
            'background': '#f1d600'
         }
      },
      'theme'   : 'classic',
      'position': 'bottom-left',
      'content' : {
         'message': 'Bu websitesi, sitemizden en iyi şekilde yararlandığınızdan emin olmak için çerezler kullanır.',
         'dismiss': 'Anladım',
         'link'   : 'Daha Fazla Bilgi'
      }
   });

   $('.search-input').typeahead({
      source     : function(request, response) {
         $.ajax({
            url       : "{{ route('autocompleteSearch') }}",
            type      : 'GET',
            dataType  : 'JSON',
            data      : {query: $('.search-input').val()},
            beforeSend: function() {
               $('#search-icon').removeClass('fa-paper-search').addClass('fa-spinner fa-spin');
            },
            success   : function(data) {
               response($.map(data, function(item) {
                  return {
                     url  : item.slug,
                     value: item.name
                  };
               }));
               $('#search-icon').removeClass('fa-spinner fa-spin').addClass('fa-search');
            }
         });
      },
      minLength  : 3,
      highlight  : true,
      displayText: function(item) {
         return item.value;
      },
      updater    : function(event) {
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

   (function() {
      'use strict';
      var forms = document.querySelectorAll('.needs-validation');
      Array.prototype.slice.call(forms).forEach(function(form) {
         form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
               event.preventDefault();
               event.stopPropagation();
            }
            form.classList.add('was-validated');
         }, false);
      });
   })();
</script>
@yield('custom-js')
</body>
</html>
