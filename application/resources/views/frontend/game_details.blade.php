<div class="row">
    <div class="col">
        <div class="card game-info">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td><i class="fas fa-bookmark" style="color: orangered"></i> {{ __('Tür') }}</td>
                            <td><i class="fas fa-calculator" style="color: blueviolet"></i> {{ __('Geliştirici') }}</td>
                            <td><i class="fas fa-newspaper" style="color: wheat"></i> {{ __('Dağıtıcı') }}</td>
                            <td><i class="fas fa-child" style="color: cornflowerblue"></i> {{ __('Yaş Sınırı') }}</td>
                            <td><i class="fas fa-laptop" style="color: gray"></i> {{ __('Platform') }}</td>
                            <td><i class="fas fa-calendar-alt" style="color: forestgreen"></i> {{ __('Çıkış Tarihi') }}</td>
                            <td><i class="fas fa-globe" style="color: deepskyblue"></i> {{ __('Resmi Website') }}</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $game_genres }}</td>
                            <td>
                                <a href="{{ route('developer', [$game->developer->slug]) }}"
                                   class="game-detail-links text-decoration-none" target="_blank"
                                   title="{{ $game->developer->name }}">
                                    {{ $game->developer->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('publisher', [$game->publisher->slug]) }}"
                                   class="game-detail-links text-decoration-none" target="_blank"
                                   title="{{ $game->publisher->name }}">
                                    {{ $game->publisher->name }}
                                </a>
                            </td>
                            <td>
                                <img src="{{asset('assets/pegi_ratings/pegi_') . $game->details->age_rating . '.png'}}"
                                     class="img-fluid" alt="pegi_rating" width="30" height="30"
                                     title="{{ $game->details->age_rating }} yaş ve üzeri">
                            </td>
                            <td>{{ $game_platforms }}</td>
                            <td>{{ Carbon\Carbon::parse($game->details->release_date)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ $game->details->website }}" class="game-detail-links text-decoration-none"
                                   target="_blank">{{ $game->name }}</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
