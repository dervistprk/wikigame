<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Developers;
use App\Models\Games;
use App\Models\Publishers;
use App\Models\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        view()->share('categories', Categories::where('status', '=', 1)->orderBy('name', 'asc')->get());
        view()->share('settings', Settings::find(1));
    }

    public function maintenance()
    {
        return view('frontend.errors.maintenance');
    }

    public function home()
    {
        $latest_games     = Games::where('status', '=', 1)->orderBy('created_at', 'desc')->take(8)->get();
        $popular_games    = Games::where('status', '=', 1)->orderBy('hit', 'desc')->take(8)->get();
        $latest_articles  = Articles::where('status', '=', 1)->orderBy('created_at', 'desc')->take(4)->get();
        $popular_articles = Articles::where('status', '=', 1)->orderBy('hit', 'desc')->take(4)->get();
        if ($latest_games->count() > 0 && $popular_games->count() > 0) {
            return view('frontend.home', compact('latest_games', 'popular_games', 'latest_articles', 'popular_articles'));
        }

        return view('frontend.home');
    }

    public function randomGame()
    {
        $game = Games::inRandomOrder()->where('status', '=', 1)->first();
        if ($game != null) {
            $developer      = $game->developer;
            $publisher      = $game->publisher;
            $game_details   = $game->details;
            $system_req_min = $game->systemReqMin;
            $system_req_rec = $game->systemReqRec;
            $other_games    = Games::where([
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
        $game_category = Categories::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $games         = $game_category->games()->paginate(12);

        return view('frontend.category', compact('games', 'game_category'));
    }

    public function search(Request $request)
    {
        $search     = $request->input('search');
        $games      = Games::where('status', '=', 1)->where('name', 'like', '%' . $search . '%')->get();
        $developers = Developers::where('status', '=', 1)->where('name', 'like', '%' . $search . '%')->get();
        $publishers = Publishers::where('status', '=', 1)->where('name', 'like', '%' . $search . '%')->get();
        $articles   = Articles::where('status', '=', 1)->where('title', 'like', '%' . $search . '%')->get();

        if ($games || $developers || $publishers || $articles) {
            return view('frontend.search', compact('games', 'developers', 'publishers', 'articles'));
        } else {
            return redirect()->route('search');
        }
    }

    public function autoComplete(Request $request)
    {
        /*$query      = $request->get('query');
        $games      = \DB::table('games')->select('id', 'name', 'slug')->where('name', 'LIKE', '%' . $query . '%')->orderBy('name')->get();
        $developers = \DB::table('developers')->select('id', 'name', 'slug')->where('name', 'LIKE', '%' . $query . '%')->get();
        $publishers = \DB::table('publishers')->select('id', 'name', 'slug')->where('name', 'LIKE', '%' . $query . '%')->get();
        return json_encode([
                               'games'      => $games,
                               'developers' => $developers,
                               'publishers' => $publishers
                           ]);*/

        $query   = $request->get('query');
        $results = \DB::table('games')->select('id', 'name', 'slug')->where('name', 'LIKE', '%' . $query . '%')->orderBy('name')->get();
        return response()->json($results);
    }
}
