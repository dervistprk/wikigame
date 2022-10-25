<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Publisher;
use App\Models\Setting;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {}

    public function dashboard()
    {
        $games      = Game::orderBy('created_at', 'desc')->take(5)->get();
        $categories = Category::orderBy('created_at', 'desc')->take(5)->get();
        $developers = Developer::orderBy('created_at', 'desc')->take(5)->get();
        $publishers = Publisher::orderBy('created_at', 'desc')->take(5)->get();
        $articles   = Article::orderBy('created_at', 'desc')->take(5)->get();
        $platforms  = Platform::orderBy('created_at', 'desc')->take(5)->get();
        $genres     = Genre::orderBy('created_at', 'desc')->take(5)->get();

        $games_count      = $games ? Game::count() : 0;
        $categories_count = $categories ? Category::count() : 0;
        $developers_count = $developers ? Developer::count() : 0;
        $publishers_count = $publishers ? Publisher::count() : 0;
        $articles_count   = $articles ? Article::count() : 0;
        $platform_count   = $platforms ? Platform::count() : 0;
        $genre_count      = $genres ? Genre::count() : 0;

        $site_status = Setting::find(1)->site_status;

        return view(
            'backend.dashboard',
            compact(
                'games',
                'categories',
                'developers',
                'publishers',
                'games_count',
                'articles',
                'platforms',
                'genres',
                'categories_count',
                'developers_count',
                'publishers_count',
                'articles_count',
                'platform_count',
                'genre_count',
                'site_status'
            )
        );
    }

    public function admin()
    {
        $admin = \Auth::user();
        return view('backend.auth.admin', compact('admin'));
    }

    public function adminPost(Request $request)
    {
        $request->validate([
            'email'            => 'email|required',
            'current_password' => 'required',
            'password'         => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'max:255',
                'different:current_password'
            ],
        ]);
        $admin = \Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->route('admin.profile')->withErrors(
                'Mevcut şifrenizi yanlış girdiniz. Lütfen tekrar deneyin.'
            );
        }

        $admin->email                = $request->email;
        $admin->password             = Hash::make($request->password);
        $admin->password_change_time = Carbon::now();
        $admin->save();
        return redirect()->route('admin.dashboard')->with('message', 'Yönetici Bilgileri Başarı ile Güncellendi.');
    }
}
