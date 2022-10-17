<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Publisher;

class GameController extends Controller
{
    public function __construct() {}

    public function list()
    {
        $games = Game::active()->orderBy('name')->paginate(12);
        return view('frontend.all_games', compact('games'));
    }

    public function gameDetails($slug)
    {
        $game = Game::with(
            'details',
            'images',
            'videos',
            'developer',
            'publisher',
            'platforms',
            'genres',
            'comments',
            'parentComments'
        )->active()->where('slug', '=', $slug)->firstOrFail();

        $game_genres = $game->genres->pluck('name')->toArray();
        $game_genres = implode(' - ', $game_genres);

        $game_platforms = $game->platforms->pluck('name')->toArray();
        $game_platforms = implode(' - ', $game_platforms);
        //TODO: yorumlar için daha fazla yükle(load more button) şeklinde sayfalama yap.

        $game->increment('hit');
        $video_count = 1;

        $other_games = Game::active()->where([
            ['category_id', '=', $game->category_id],
            ['id', '!=', $game->id]
        ])->orderBy('hit', 'desc')->take(4)->get();

        return view('frontend.game', compact('game', 'other_games', 'video_count', 'game_genres', 'game_platforms'));
    }

    public function developers()
    {
        $developers = Developer::active()->orderBy('name')->paginate(12);
        return view('frontend.lists.developers', compact('developers'));
    }

    public function developer($slug)
    {
        $developer = Developer::active()->where('slug', '=', $slug)->firstOrFail();
        $games     = $developer->games()->active()->paginate(12);
        return view('frontend.developer', compact('developer', 'games'));
    }

    public function publishers()
    {
        $publishers = Publisher::active()->orderBy('name')->paginate(12);
        return view('frontend.lists.publishers', compact('publishers'));
    }

    public function publisher($slug)
    {
        $publisher = Publisher::active()->where('slug', '=', $slug)->firstOrFail();
        $games     = $publisher->games()->active()->paginate(12);
        return view('frontend.publisher', compact('publisher', 'games'));
    }

    public function gameComments()
    {

    }
}
