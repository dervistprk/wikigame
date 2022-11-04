<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    @yield('redirect-js')
    <meta name="description" content="{{ $settings->meta_description }}"/>
    <meta name="author" content="WikiGame"/>
    <title>@yield('title') - WikiGame</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}"/>
    <link href="{{ asset('css/bootstrap-5.1.3.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/jquery-ui-blitzer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/cookie-sent-3.min.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/ui/trumbowyg.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/giphy/ui/trumbowyg.giphy.min.css"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/emoji/ui/trumbowyg.emoji.min.css"
          rel="stylesheet"/>
    @yield('custom-css')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KY0WRBH1EE"></script>
    <script>
       window.dataLayer = window.dataLayer || [];

       function gtag() {
          dataLayer.push(arguments);
       }

       gtag('js', new Date());
       gtag('config', 'G-KY0WRBH1EE');
    </script>
</head>
<body>
@include('layouts.header')
@yield('content')
<button class="btn btn-warning rounded-circle" onclick="topFunction()" id="topBtn" data-toggle="tooltip"
        data-placement="top" title="En Üste Git">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/langs/tr.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/emoji/trumbowyg.emoji.min.js"
        type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/giphy/trumbowyg.giphy.min.js"
        type="text/javascript"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.1.1/dist/flasher.min.js"></script>
<script type="text/javascript">
   window.cookieconsent.initialise({
      'palette' : {
         'popup' : {
            'background': '#000000',
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

   $('.search-input').autocomplete({
      source   : function(request, response) {
         $.ajax({
            url       : '{{ route('autocompleteSearch') }}',
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
                     img  : item.cover_image
                  };
               }));
               $('#search-icon').removeClass('fa-spinner fa-spin').addClass('fa-search');
            },
         });
      },
      open     : function() {
         $('ul.ui-autocomplete').addClass('opened').css({'top': '120px', 'padding': '7px'});
         if ($('body').data('theme') == 'dark') {
            $('ul.ui-autocomplete').css({'background': "#222222", 'color': 'white', 'border-color': '#333333'});
         } else {
            $('ul.ui-autocomplete').css({'color': 'black'});
         }
      },
      close    : function() {
         $('ul.ui-autocomplete').removeClass('opened').css('display', 'block');
      },
      minLength: 3,
      delay    : 300,
      select   : function(event, ui) {
         event.preventDefault();
         if (ui.item.img != '') {
            window.location.href = '/oyun/' + ui.item.url;
         } else {
            window.location.href = ui.item.url;
         }
      },
      response : function(event, ui) {
         if (!ui.content.length) {
            var no_result = {url: '#', value: 'Sonuç Bulunamadı', img: ''};
            ui.content.push(no_result);
         } else {
            var see_all = {
               url  : '/arama?search=' + encodeURIComponent($('.search-input').val()),
               value: 'Tümünü Gör',
               img  : ''
            };
            ui.content.push(see_all);
         }
      },
      focus    : function(event, ui) {
         event.preventDefault();
      },
   }).autocomplete('instance')._renderItem = function(ul, item) {
      if ($('body').data('theme') == 'dark') {
         $('<style>').text('li.custom-autocomplete-list a {color:#f8f8f8;}').appendTo('head');
         $('<style>').text('li.custom-autocomplete-list:hover {background:#333333;}').appendTo('head');
         $('<style>').text('li.custom-autocomplete-list .ui-menu-item-wrapper {background:transparent; border-color:transparent;}').appendTo('head');
      } else {
         $('<style>').text('li.custom-autocomplete-list:hover {background:#f8f8f8;}').appendTo('head');
         $('<style>').text('li.custom-autocomplete-list .ui-menu-item-wrapper {background:transparent; border-color:transparent;}').appendTo('head');
      }

      if (item.img != '') {
         return $('<li class="custom-autocomplete-list" style="margin-top: 5px; padding: 7px"></li>').data('item.autocomplete', item)
            .append('<a style="text-decoration: none">' + "<img src='" + item.img + "' style='margin-right: 4px' alt='cover-image' width='50' height='65'/>" + item.value + '</a>').appendTo(ul);
      } else if (item.url == '#') {
         return $('<li class="custom-autocomplete-list text-center" style="margin-top: 5px; padding: 7px; pointer-events: none;"></li>').data('item.autocomplete', item)
            .append('<span style="text-decoration: none">' + item.value + '</span>').appendTo(ul);
      } else {
         return $('<li class="custom-autocomplete-list text-center" style="margin-top: 5px; padding: 7px;"></li>').data('item.autocomplete', item)
            .append('<span style="text-decoration: none">' + item.value + '</span>').appendTo(ul);
      }
   };

   $('#btnNavbarSearch').on('click', function() {
      if ($('.search-input').val() == '') {
         return false;
      }
      window.location.href = 'arama?search=' + encodeURIComponent($('.search-input').val());
   });

   $('.search-input').on('keydown, keypress', function(e) {
      var key = e.keyCode || e.which;
      if (key == 13) {
         if (parseInt($(this).val().length) > 2) {
            $('#btnNavbarSearch').click();
         } else {
            alert('Arama yapabilmek için lütfen en az 3 harf girin.');
            e.preventDefault();
         }
      }
   });

   $('.search-input').blur(function() {
      $('ul.ui-autocomplete').fadeOut(300);
   });

   $(window).on('scroll', function() {
      $('ul.ui-autocomplete').fadeOut(300);
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
      btns             : [
         ['undo', 'redo'],
         ['formatting'],
         ['strong', 'em', 'del'],
         ['link'],
         ['unorderedList', 'orderedList'],
         ['horizontalRule'],
         ['removeformat'],
         ['emoji'],
         ['giphy'],
         ['fullscreen'],
      ],
      plugins          : {
         giphy: {
            apiKey: '3K2ElrEpAV2QMVV6NjiRLagpY5sS69ae',
            rating: 'pg',
         },
      },
      lang             : 'tr',
      resetCss         : true,
      defaultLinkTarget: '_blank',
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
