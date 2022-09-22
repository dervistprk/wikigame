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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/ui/trumbowyg.min.css" integrity="sha512-K87nr2SCEng5Nrdwkb6d6crKqDAl4tJn/BD17YCXH0hu2swuNMqSV6S8hTBZ/39h+0pDpW/tbQKq9zua8WiZTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/giphy/ui/trumbowyg.giphy.min.css" integrity="sha512-ZVJ2H8aNqbzloKqMTPKqbgoRW8DXq4tDQhnWwG/uocwbwQjQmhp1LVh69j1e9uveC3lW7Dei2BGjyo1Tq8IHvw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/emoji/ui/trumbowyg.emoji.min.css" integrity="sha512-iE+NA+i8IqPfRFNWpyhtuf5J6MVJxRFD9fopri96sn5e3epH9LKnANGerPHIjZcIsjbq7kqXIhrnqtMlzNGpvw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js" integrity="sha512-mBsoM2hTemSjQ1ETLDLBYvw6WP9QV8giiD33UeL2Fzk/baq/AibWjI75B36emDB6Td6AAHlysP4S/XbMdN+kSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/langs/tr.min.js" integrity="sha512-SysH9TbVmzlYAKIvJJcHAwQtT5TznKnZSC9/hZqew8gSmmnCW4tTvdIEjQRfc3W7fYhrKRnpegQpxzD+ti6Yng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/emoji/trumbowyg.emoji.min.js" integrity="sha512-wyeD6Aca6BA4SSpbhB6ohjxYu/msHVzYjiRqjm1gqluF6V09kjr28wnZ1jFxkabX2x0/GBdeGStjoeH9Fr1l6w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/giphy/trumbowyg.giphy.min.js" integrity="sha512-NbqTgW+76nDcWRoGWnxMmJu3uDEbg0DJVIwhdBfDd/rIxa/NY/BXkcx4EsEG9p496PMt1L/Gykz5062LVZDjjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
   window.cookieconsent.initialise({
      'palette' : {
         'popup' : {
            'background': '#000',
         },
         'button': {
            'background': '#f1d600',
         },
      },
      'theme'   : 'classic',
      'position': 'bottom-left',
      'content' : {
         'message': 'Bu websitesi, sitemizden en iyi şekilde yararlandığınızdan emin olmak için çerezler kullanır.',
         'dismiss': 'Anladım',
         'link'   : 'Daha Fazla Bilgi',
      },
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
                     value: item.name,
                  };
               }));
               $('#search-icon').removeClass('fa-spinner fa-spin').addClass('fa-search');
            },
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
      maxDate    : '+0D',
   });

   $('.date-picker').attr('readonly', true).css({
      'cursor': 'pointer',
   });

   $('.comment-text').trumbowyg({
      btns                    : [
         ['undo', 'redo'], // Only supported in Blink browsers
         ['formatting'],
         ['strong', 'em', 'del'],
         ['superscript', 'subscript'],
         ['link'],
         ['unorderedList', 'orderedList'],
         ['horizontalRule'],
         ['removeformat'],
         ['emoji'],
         ['giphy'],
         ['fullscreen'],
      ],
      plugins: {
         giphy: {
            apiKey: '3K2ElrEpAV2QMVV6NjiRLagpY5sS69ae',
            rating: 'pg',
         }
      },
      lang                    : 'tr',
      resetCss                : true,
      defaultLinkTarget       : '_blank',
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
