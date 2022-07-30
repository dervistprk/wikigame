<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Developers;
use App\Models\Games;
use App\Models\Publishers;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admins;

class AdminController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Settings::find(1));
    }

    public function dashboard()
    {
        $games      = Games::where('status', '=', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $categories = Categories::where('status', '=', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $developers = Developers::where('status', '=', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $publishers = Publishers::where('status', '=', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $articles   = Articles::where('status', '=', 1)->orderBy('created_at', 'desc')->take(5)->get();

        $games_count      = Games::where('status', '=', 1)->count();
        $categories_count = Categories::where('status', '=', 1)->count();
        $developers_count = Developers::where('status', '=', 1)->count();
        $publishers_count = Publishers::where('status', '=', 1)->count();
        $articles_count   = Articles::where('status', '=', 1)->count();

        $site_status = Settings::find(1)->site_status;

        return view('backend.dashboard', compact('games', 'categories', 'developers', 'publishers', 'games_count', 'articles', 'categories_count', 'developers_count', 'publishers_count', 'articles_count', 'site_status'));
    }

    public function admin()
    {
        $admin = User::where('is_admin', 1)->first();
        return view('backend.auth.admin', compact('admin'));
    }

    public function adminPost(Request $request)
    {
        $request->validate([
                               'email'    => 'email|required',
                               'password' => [
                                   'required',
                                   'min:6',
                                   'regex:/[a-z]/',
                                   'regex:/[A-Z]/',
                                   'regex:/[0-9]/',
                               ],
                           ]);
        $admin           = Admins::first();
        $admin->email    = $request->email;
        $admin->password = \Hash::make($request->password);
        $admin->save();
        return redirect()->route('admin.dashboard')->with('message', 'Yönetici Bilgileri Başarı ile Güncellendi.');
    }
}
