<table class="table table-sm game-info">
    <tbody>
    <tr>
        <th style="width: 250px"><i class="fas fa-bookmark" style="color: orangered"></i> Türü</th>
        <td>{{ $game_details->genre }}</td>
    </tr>
    <tr>
        <th><i class="fas fa-calculator" style="color: blueviolet"></i> Geliştirici</th>
        <td>
            <a href="{{ route('developer', [$developer->slug]) }}" class="game-detail-links text-decoration-none" target="_blank" title="{{ $developer->name }}">
                {{ $developer->name }}
            </a>
        </td>
    </tr>
    <tr>
        <th><i class="fas fa-newspaper" style="color: wheat"></i> Dağıtıcı</th>
        <td>
            <a href="{{ route('publisher', [$publisher->slug]) }}" class="game-detail-links text-decoration-none" target="_blank" title="{{ $publisher->name }}">
                {{ $publisher->name }}
            </a>
        </td>
    </tr>
    <tr>
        <th><i class="fas fa-child" style="color: cornflowerblue"></i> Yaş Sınırı</th>
        <td>
            <img src="{{asset('assets/pegi_ratings/pegi_') . $game_details->age_rating . '.png'}}" alt="pegi_rating" width="25" height="25" title="{{ $game_details->age_rating }} yaş ve üzeri">
        </td>
    </tr>
    <tr>
        <th><i class="fas fa-laptop" style="color: gray"></i> Platform</th>
        <td>{{ $game_details->platform }}</td>
    </tr>
    <tr>
        <th><i class="fas fa-calendar-alt" style="color: forestgreen"></i> Çıkış Tarihi</th>
        <td>{{ Carbon\Carbon::parse($game_details->release_date)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <th><i class="fas fa-globe" style="color: deepskyblue"></i> Resmi Website</th>
        <td>
            <a href="{{ $game_details->website }}" class="game-detail-links text-decoration-none" target="_blank">{{ $game->name }}</a>
        </td>
    </tr>
    </tbody>
</table>
