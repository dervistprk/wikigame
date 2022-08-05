<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Developers;
use App\Models\Games;
use App\Models\Publishers;
use App\Models\Settings;
use Cache;

class GamesController extends Controller
{
    public function __construct()
    {
        view()->share('categories', Categories::where('status', '=', 1)->get());
        view()->share('settings', Settings::find(1));
    }

    public function list()
    {
        if (Cache::has('games_list')) {
            $games = Cache::get('games_list');
        } else {
            $games = Games::where('status', '=', 1)->orderBy('name', 'asc')->paginate(12);
            Cache::put('games_list', $games, env('cache_expire'));
        }

        if ($games->count() > 0) {
            return view('frontend.all_games', compact('games'));
        }

        return view('frontend.all_games');
    }

    public function gameDetails($slug)
    {

        $game           = Games::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $developer      = $game->developer;
        $publisher      = $game->publisher;
        $game_details   = $game->details;
        $system_req_min = $game->systemReqMin;
        $system_req_rec = $game->systemReqRec;
        $game->increment('hit');

        $other_games = Games::where([
           ['status', '=', 1],
           ['category_id', '=', $game->category_id],
           ['id', '!=', $game->id]
        ])->orderBy('hit', 'desc')->take(4)->get();

        return view('frontend.game', compact('game', 'developer', 'publisher', 'game_details', 'system_req_min', 'system_req_rec', 'other_games'));
    }

    public function developers()
    {
        if (Cache::has('developers')) {
            $developers = Cache::get('developers');
        } else {
            $developers = Developers::where('status', '=', 1)->orderBy('name', 'asc')->paginate(12);
            Cache::put('developers', $developers, env('cache_expire'));
        }

        if ($developers->count() > 0) {
            return view('frontend.lists.developers', compact('developers'));
        }

        return view('frontend.lists.developers');
    }

    public function developer($slug)
    {
        $developer = Developers::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $games     = $developer->games()->where('status', '=', 1)->paginate(12);

        return view('frontend.developer', compact('developer', 'games'));
    }

    public function publishers()
    {
        if (Cache::has('publishers')) {
            $publishers = Cache::get('publishers');
        } else {
            $publishers = Publishers::where('status', '=', 1)->orderBy('name', 'asc')->paginate(12);
        }

        if ($publishers->count() > 0) {
            return view('frontend.lists.publishers', compact('publishers'));
        }

        return view('frontend.lists.publishers');
    }

    public function publisher($slug)
    {
        $publisher = Publishers::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $games     = $publisher->games()->where('status', '=', 1)->paginate(12);

        return view('frontend.publisher', compact('publisher', 'games'));
    }
}
