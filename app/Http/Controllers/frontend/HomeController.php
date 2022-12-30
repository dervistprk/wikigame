<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\SearchView;
use Illuminate\Http\Request;
use Cache;

class HomeController extends Controller
{
    public function __construct() {}

    public function maintenance()
    {
        return view('frontend.errors.maintenance');
    }

    public function home()
    {
        if (Cache::has('latest_games')) {
            $latest_games = Cache::get('latest_games');
        } else {
            $latest_games = Game::active()->orderBy('created_at', 'desc')->take(8)->get();
            Cache::put('latest_games', $latest_games, config('app.cache_expire'));
        }

        if (Cache::has('popular_games')) {
            $popular_games = Cache::get('popular_games');
        } else {
            $popular_games = Game::active()->orderBy('hit', 'desc')->take(8)->get();
            Cache::put('popular_games', $popular_games, config('app.cache_expire'));
        }

        if (Cache::has('latest_articles')) {
            $latest_articles = Cache::get('latest_articles');
        } else {
            $latest_articles = Article::active()->orderBy('created_at', 'desc')->take(4)->get();
            Cache::put('latest_articles', $latest_articles, config('app.cache_expire'));
        }

        if (Cache::has('popular_articles')) {
            $popular_articles = Cache::get('popular_articles');
        } else {
            $popular_articles = Article::active()->orderBy('hit', 'desc')->take(4)->get();
            Cache::put('popular_articles', $popular_articles, config('app.cache_expire'));
        }

        return view('frontend.home', compact('latest_games', 'popular_games', 'latest_articles', 'popular_articles'));
    }

    public function randomGame()
    {
        $game = Game::with(
            'developer',
            'publisher',
            'details',
            'systemReqMin',
            'systemReqRec',
            'images',
            'videos'
        )->inRandomOrder()->active()->first();

        if ($game) {
            $other_games = Game::active()->where([
                ['category_id', '=', $game->category_id],
                ['id', '!=', $game->id]
            ])->orderBy('hit', 'desc')->take(4)->get();

            $parent_comments = $game->parentComments()->paginate(5, ['*'], 'yorumlar');
            $game_platforms  = $game->platforms->pluck('name')->toArray();
            $game_platforms  = implode(' - ', $game_platforms);
            $comment_replies = [];

            if ($parent_comments) {
                foreach ($parent_comments as $parent_comment) {
                    foreach ($parent_comment->replies as $reply) {
                        $comment_replies[$parent_comment->id][] = $reply;
                    }
                }
            }

            $video_count = 1;
            $game_genres = $game->genres->pluck('name')->toArray();
            $game_genres = implode(', ', $game_genres);

            return view('frontend.game',
                compact(
                    'game',
                    'other_games',
                    'video_count',
                    'game_genres',
                    'game_platforms',
                    'parent_comments',
                    'comment_replies'
                ));
        }

        return view('frontend.game');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function category($slug)
    {
        $game_category = Category::active()->where('slug', '=', $slug)->firstOrFail();
        $games         = $game_category->games()->active()->paginate(12);

        return view('frontend.category', compact('games', 'game_category'));
    }

    public function search(Request $request)
    {
        $search     = htmlspecialchars(trim($request->input('search')));
        $games      = Game::active()->where('name', 'like', '%' . $search . '%')->get();
        $developers = Developer::active()->where('name', 'like', '%' . $search . '%')->get();
        $publishers = Publisher::active()->where('name', 'like', '%' . $search . '%')->get();
        $articles   = Article::active()->where('title', 'like', '%' . $search . '%')->get();

        if ($games || $developers || $publishers || $articles) {
            return view('frontend.search', compact('games', 'developers', 'publishers', 'articles'));
        } else {
            return redirect()->route('search');
        }
    }

    public function autoComplete(Request $request)
    {
        $query   = htmlspecialchars(trim($request->get('query')), ENT_QUOTES);
        $results = SearchView::select(['id', 'name', 'slug', 'cover_image'])->where('name', 'LIKE', '%' . $query . '%')
                             ->orWhere('developer_name', 'LIKE', '%' . $query . '%')
                             ->orWhere('publisher_name', 'LIKE', '%' . $query . '%')
                             ->active()->orderBy('release_date', 'desc')->limit(3)->get();
        return response()->json($results);
    }

    public function switchLanguage(Request $request)
    {
        if ($request->ajax()) {
            $locale = $request->get('locale');
            app()->setLocale($locale);
            session()->put('locale', $locale);
            return true;
        }
        return false;
    }
}
