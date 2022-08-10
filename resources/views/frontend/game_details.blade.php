<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered rounded">
                    <thead>
                    <tr>
                        <td><i class="fas fa-bookmark" style="color: orangered"></i> Türü</td>
                        <td><i class="fas fa-calculator" style="color: blueviolet"></i> Geliştirici</td>
                        <td><i class="fas fa-newspaper" style="color: wheat"></i> Dağıtıcı</td>
                        <td><i class="fas fa-child" style="color: cornflowerblue"></i> Yaş Sınırı</td>
                        <td><i class="fas fa-laptop" style="color: gray"></i> Platform</td>
                        <td><i class="fas fa-calendar-alt" style="color: forestgreen"></i> Çıkış Tarihi</td>
                        <td><i class="fas fa-globe" style="color: deepskyblue"></i> Resmi Website</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $game_details->genre }}</td>
                        <td>
                            <a href="{{ route('developer', [$developer->slug]) }}" class="game-detail-links text-decoration-none" target="_blank" title="{{ $developer->name }}">
                                {{ $developer->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('publisher', [$publisher->slug]) }}" class="game-detail-links text-decoration-none" target="_blank" title="{{ $publisher->name }}">
                                {{ $publisher->name }}
                            </a>
                        </td>
                        <td>
                            <img src="{{asset('assets/pegi_ratings/pegi_') . $game_details->age_rating . '.png'}}" class="img-fluid" alt="pegi_rating" width="30" height="30" title="{{ $game_details->age_rating }} yaş ve üzeri">
                        </td>
                        <td>{{ $game_details->platform }}</td>
                        <td>{{ Carbon\Carbon::parse($game_details->release_date)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ $game_details->website }}" class="game-detail-links text-decoration-none" target="_blank">{{ $game->name }}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
