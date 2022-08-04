<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Settings;
use Cache;

class ArticlesController extends Controller
{
    public function __construct()
    {
        view()->share('categories', Categories::where('status', '=', 1)->get());
        view()->share('settings', Settings::find(1));
    }

    public function articles()
    {
        if (Cache::has('articles')) {
            $articles = Cache::get('articles');
        } else {
            $articles = Articles::where('status', '=', 1)->orderBy('created_at', 'desc')->paginate(5);
            Cache::put('articles', $articles, 1800);
        }
        $popular_articles = Articles::where('status', '=', 1)->orderBy('hit', 'desc')->take(5)->get();
        return view('frontend.all_articles', compact('articles', 'popular_articles'));
    }

    public function article($slug)
    {
        if (Cache::has('article')) {
            $article = Cache::get('article');
        } else {
            $article = Articles::where('status', '=', 1)->where('slug', '=', $slug)->first();
            Cache::put('article', $article, 3600);
        }

        $article->increment('hit');
        $random_articles = Articles::where('status', '=', 1)->where('slug', '!=', $slug)->inRandomOrder()->take(3)->get();
        return view('frontend.article', compact('article', 'random_articles'));
    }
}
