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
    public function __construct()
    {
        view()->share('categories', Category::where('status', '=', 1)->get());
        view()->share('settings', Setting::find(1));
    }

    public function list()
    {
        $games = Game::where('status', '=', 1)->orderBy('name', 'asc')->paginate(12);
        if ($games->count() > 0) {
            return view('frontend.all_games', compact('games'));
        }

        return view('frontend.all_games');
    }

    public function gameDetails($slug)
    {

        $game           = Game::where('status', '=', 1)->where('slug', '=', $slug)->firstOrFail();
        $developer      = $game->developer;
        $publisher      = $game->publisher;
        $game_details   = $game->details;
        $system_req_min = $game->systemReqMin;
        $system_req_rec = $game->systemReqRec;
        $game->increment('hit');

        $other_games = Game::where([
           ['status', '=', 1],
           ['category_id', '=', $game->category_id],
           ['id', '!=', $game->id]
        ])->orderBy('hit', 'desc')->take(4)->get();

        return view('frontend.game', compact('game', 'developer', 'publisher', 'game_details', 'system_req_min', 'system_req_rec', 'other_games'));
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
