<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use Cache;

class ArticleController extends Controller
{
    public function __construct() {}

    public function articles()
    {
        $articles         = Article::active()->orderBy('created_at', 'desc')->paginate(5);
        $popular_articles = Article::active()->orderBy('hit', 'desc')->take(5)->get();
        $random_articles  = Article::active()->inRandomOrder()->take(5)->get();
        return view('frontend.all_articles', compact('articles', 'popular_articles', 'random_articles'));
    }

    public function article($slug)
    {
        $article         = Article::active()->where('slug', '=', $slug)->firstOrFail();
        $random_articles = Article::active()->where('slug', '!=', $slug)->inRandomOrder()->take(3)->get();
        $article->increment('hit');
        return view('frontend.article', compact('article', 'random_articles'));
    }
}
