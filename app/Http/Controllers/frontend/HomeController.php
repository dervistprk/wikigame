<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\Setting;
use Illuminate\Http\Request;
use Cache;

class HomeController extends Controller
{
    public function __construct()
    {
        view()->share('categories', Category::where('status', '=', 1)->orderBy('name', 'asc')->get());
        view()->share('settings', Setting::find(1));
    }

    public function maintenance()
    {
        return view('frontend.errors.maintenance');
    }

    public function home()
    {
        if (Cache::has('latest_games')) {
            $latest_games = Cache::get('latest_games');
        } else {
            $latest_games     = Game::where('status', '=', 1)->orderBy('created_at', 'desc')->take(8)->get();
            Cache::put('latest_games', $latest_games, env('cache_expire'));
        }

        if (Cache::has('popular_games')) {
            $popular_games = Cache::get('popular_games');
        } else {
            $popular_games    = Game::where('status', '=', 1)->orderBy('hit', 'desc')->take(8)->get();
            Cache::put('popular_games', $popular_games, env('cache_expire'));
        }

        if (Cache::has('latest_articles')) {
            $latest_articles = Cache::get('latest_articles');
        } else {
            $latest_articles  = Article::where('status', '=', 1)->orderBy('created_at', 'desc')->take(4)->get();
            Cache::put('latest_articles', $latest_articles, env('cache_expire'));
        }

        if (Cache::has('popular_articles')) {
            $popular_articles = Cache::get('popular_articles');
        } else {
            $popular_articles = Article::where('status', '=', 1)->orderBy('hit', 'desc')->take(4)->get();
            Cache::put('popular_articles', $popular_articles, env('cache_expire'));
        }

        if ($latest_games->count() > 0 && $latest_articles->count() > 0) {
            return view('frontend.home', compact('latest_games', 'popular_games', 'latest_articles', 'popular_articles'));
        }

        return view('frontend.home');
    }

    public function randomGame()
    {
        $game = Game::inRandomOrder()->where('status', '=', 1)->first();
        if ($game != null) {
            $developer      = $game->developer;
            $publisher      = $game->publisher;
            $game_details   = $game->details;
            $system_req_min = $game->systemReqMin;
            $system_req_rec = $game->systemReqRec;
            $other_games    = Game::where([
                   ['status', '=', 1],
                   ['category_id', '=', $game->category_id],
                   ['id', '!=', $game->id]
            ])->orderBy('hit', 'desc')->take(4)->get();

            return view('frontend.game', compact('game', 'developer', 'publisher', 'game_details', 'system_req_min', 'system_req_rec', 'other_games'));
        }

        return view('frontend.game');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function category($slug)
    {
        $game_category = Category::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $games         = $game_category->games()->paginate(12);

        return view('frontend.category', compact('games', 'game_category'));
    }

    public function search(Request $request)
    {
        $search     = $request->input('search');
        $games      = Game::where('status', '=', 1)->where('name', 'like', '%' . $search . '%')->get();
        $developers = Developer::where('status', '=', 1)->where('name', 'like', '%' . $search . '%')->get();
        $publishers = Publisher::where('status', '=', 1)->where('name', 'like', '%' . $search . '%')->get();
        $articles   = Article::where('status', '=', 1)->where('title', 'like', '%' . $search . '%')->get();

        if ($games || $developers || $publishers || $articles) {
            return view('frontend.search', compact('games', 'developers', 'publishers', 'articles'));
        } else {
            return redirect()->route('search');
        }
    }

    public function autoComplete(Request $request)
    {
        $query   = $request->get('query');
        $results = \DB::table('games')->select('id', 'name', 'slug')->where('name', 'LIKE', '%' . $query . '%')->orderBy('name')->get();
        return response()->json($results);
    }
}
