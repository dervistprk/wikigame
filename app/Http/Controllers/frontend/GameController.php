<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Publisher;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct() {}

    public function list(Request $request)
    {
        $games      = Game::active()->orderBy('name');
        $categories = Category::active()->orderBy('name')->get();
        $developers = Developer::active()->orderBy('name')->get();
        $publishers = Publisher::active()->orderBy('name')->get();
        $genres     = Genre::active()->orderBy('name')->get();
        $platforms  = Platform::active()->orderBy('name')->get();

        if ($request->has('categories')) {
            $games = $games->whereIn('category_id', (array)$request->get('categories'));
        }

        if ($request->has('genres')) {
            $games = $games->whereHas('genres', function($q) use ($request) {
                $q->whereIn('genre_id', (array)$request->get('genres'));
            });
        }

        if ($request->has('platforms')) {
            $games = $games->whereHas('platforms', function($q) use ($request) {
                $q->whereIn('platform_id', (array)$request->get('platforms'));
            });
        }

        if ($request->has('developers')) {
            $games = $games->whereIn('developer_id', (array)$request->get('developers'));
        }

        if ($request->has('publishers')) {
            $games = $games->whereIn('publisher_id', (array)$request->get('publishers'));
        }

        $games = $games->paginate(12);

        return view('frontend.all_games', compact('games', 'categories', 'developers', 'publishers', 'genres', 'platforms'));
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

        $parent_comments = $game->parentComments()->paginate(5, ['*'], 'yorumlar');
        $game_genres     = $game->genres->pluck('name')->toArray();
        $game_genres     = implode(' - ', $game_genres);

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

        $game->increment('hit');
        $video_count = 1;

        $other_games = Game::active()->where([
            ['category_id', '=', $game->category_id],
            ['id', '!=', $game->id]
        ])->orderBy('hit', 'desc')->take(4)->get();

        return view(
            'frontend.game',
            compact(
                'game',
                'other_games',
                'video_count',
                'game_genres',
                'game_platforms',
                'parent_comments',
                'comment_replies'
            )
        );
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
}
