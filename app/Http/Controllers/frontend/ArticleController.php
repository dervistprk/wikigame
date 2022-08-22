<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use Cache;

class ArticleController extends Controller
{
    public function __construct()
    {
        view()->share('categories', Category::where('status', '=', 1)->get());
        view()->share('settings', Setting::find(1));
    }

    public function articles()
    {
        $articles         = Article::where('status', '=', 1)->orderBy('created_at', 'desc')->paginate(5);
        $popular_articles = Article::where('status', '=', 1)->orderBy('hit', 'desc')->take(5)->get();
        $random_articles  = Article::where('status', '=', 1)->inRandomOrder()->take(5)->get();
        return view('frontend.all_articles', compact('articles', 'popular_articles', 'random_articles'));
    }

    public function article($slug)
    {
        $article         = Article::where('status', '=', 1)->where('slug', '=', $slug)->first();
        $random_articles = Article::where('status', '=', 1)->where('slug', '!=', $slug)->inRandomOrder()->take(3)->get();
        $article->increment('hit');
        return view('frontend.article', compact('article', 'random_articles'));
    }
}
