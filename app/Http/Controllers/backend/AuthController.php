<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('backend.auth.login');
    }

    public function loginPost(Request $request)
    {
        $remember = $request->input('remember_token');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember ? true : false)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->withErrors('E-Posta Adresi veya Şifre Hatalı')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
