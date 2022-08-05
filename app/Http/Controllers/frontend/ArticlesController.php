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
        $articles         = Articles::where('status', '=', 1)->orderBy('created_at', 'desc')->paginate(5);
        $popular_articles = Articles::where('status', '=', 1)->orderBy('hit', 'desc')->take(5)->get();
        return view('frontend.all_articles', compact('articles', 'popular_articles'));
    }

    public function article($slug)
    {
        $article         = Articles::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $random_articles = Articles::where('status', '=', 1)->where('slug', '!=', $slug)->inRandomOrder()->take(3)->get();
        $article->increment('hit');
        return view('frontend.article', compact('article', 'random_articles'));
    }
}
