<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('message', 'Girmiş olduğunuz hesap yönetici yetkilerine sahip değildir.');
            }
        }
        return redirect()->route('admin.login')->with('message', 'Lütfen yönetici yetkilerine sahip bir hesap ile giriş yapınız.');
    }
}
