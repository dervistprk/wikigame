<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\Setting;
use Cache;

class GameController extends Controller
{
    public function __construct() {}

    public function list()
    {
        $games = Game::where('status', '=', 1)->orderBy('name')->paginate(12);
        if ($games->count() > 0) {
            return view('frontend.all_games', compact('games'));
        }

        return view('frontend.all_games');
    }

    public function gameDetails($slug)
    {
        $game         = Game::where('status', '=', 1)->where('slug', '=', $slug)->firstOrFail();
        $game_genres  = $game->genres->pluck('name')->toArray();
        $game_genres  = implode(', ', $game_genres);
        $game_details = $game->details;


        $game->increment('hit');
        $video_count = 1;

        $other_games = Game::where([
            ['status', '=', 1],
            ['category_id', '=', $game->category_id],
            ['id', '!=', $game->id]
        ])->orderBy('hit', 'desc')->take(4)->get();

        return view('frontend.game', compact('game', 'game_details', 'other_games', 'video_count', 'game_genres'));
    }

    public function developers()
    {
        $developers = Developer::where('status', '=', 1)->orderBy('name', 'asc')->paginate(12);
        if ($developers->count() > 0) {
            return view('frontend.lists.developers', compact('developers'));
        }

        return view('frontend.lists.developers');
    }

    public function developer($slug)
    {
        $developer = Developer::where('status', '=', 1)->where('slug', '=', $slug)->firstOrFail();
        $games     = $developer->games()->where('status', '=', 1)->paginate(12);

        return view('frontend.developer', compact('developer', 'games'));
    }

    public function publishers()
    {
        $publishers = Publisher::where('status', '=', 1)->orderBy('name', 'asc')->paginate(12);
        if ($publishers->count() > 0) {
            return view('frontend.lists.publishers', compact('publishers'));
        }

        return view('frontend.lists.publishers');
    }

    public function publisher($slug)
    {
        $publisher = Publisher::where('status', '=', 1)->where('slug', '=', $slug)->firstOrFail();
        $games     = $publisher->games()->where('status', '=', 1)->paginate(12);

        return view('frontend.publisher', compact('publisher', 'games'));
    }
}
