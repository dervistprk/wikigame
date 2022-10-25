<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class isBanned
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->isBanned()) {
            Auth::logout();
            flash()->addError('Yasaklı Hesap!', 'Hata');
            return redirect()->route('login-form')->with('message', 'Bilgilerini girdiğiniz hesap sitemizden yasaklanmıştır.');
        }
        return $next($request);
    }
}
