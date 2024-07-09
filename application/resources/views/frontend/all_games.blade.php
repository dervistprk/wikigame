@extends('layouts.app')
@section('title', __('Tüm Oyunlar'))
@section('content')
    <div class="container">
        @if($games->count() > 0)
            <h2 class="game-header">{{ __('Tüm Oyunlar') }}</h2>
            @include('frontend.filter.filter_games')
            @include('frontend.lists.games')
        @else
            <div class="alert alert-secondary text-center m-2">
                {{ __('Sistemde kayıtlı oyun bulunamadı.') }}
            </div>
        @endif
    </div>
@endsection
@section('custom-js')
    <script type="text/javascript">
       $(document).ready(function() {
          var getUrlParameter = function getUrlParameter(sParam) {
             var sPageURL      = window.location.search.substring(1),
                 sURLVariables = sPageURL.split('&'),
                 sParameterName,
                 i;

             for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                   return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
             }
             return false;
          };

          var params = ['categories', 'genres', 'platforms', 'developers', 'publishers'];

          params.forEach(function(item) {
             if (getUrlParameter(item + '%5B%5D')) {
                $('#clear-btn').removeClass('disabled');
             }
          });

          var delay = 70;
          setTimeout(function() {
             var dark_theme = $(document.body).data('theme');
             if (typeof dark_theme !== 'undefined' && dark_theme !== false) {
                $('.filter-wrapper').css('color', '#f8f8ff');
             } else {
                $('.filter-wrapper').css('color', '#1a1a1a');
             }
          }, delay);

          $('#darkSwitch').on('change', function() {
             var theme = $(this).is(':checked');
             if (theme) {
                $('.filter-wrapper').css('color', '#f8f8ff');
             } else {
                $('.filter-wrapper').css('color', '#1a1a1a');
             }
          });
       });
    </script>
@endsection