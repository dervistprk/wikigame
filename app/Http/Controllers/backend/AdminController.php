<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Developers;
use App\Models\Games;
use App\Models\Publishers;
use App\Models\Settings;
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

        return view('backend.dashboard', compact('games', 'categories', 'developers', 'publishers', 'games_count', 'articles', 'categories_count', 'developers_count', 'publishers_count', 'articles_count'));
    }

    public function admin()
    {
        $admin = Admins::first();
        return view('backend.auth.admin', compact('admin'));
    }

    public function adminPost(Request $request)
    {
        $request->validate([
                               'email'    => 'email|required',
                               'password' => ['required',
                                              'min:6',
                                              'regex:/[a-z]/',
                                              'regex:/[A-Z]/',
                                              'regex:/[0-9]/',
                               ],
                           ]);
        $admin           = Admins::first();
        $admin->email    = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();
        return redirect()->route('admin.dashboard')->with('message', 'Y??netici Bilgileri Ba??ar?? ile G??ncellendi.');
    }
}
