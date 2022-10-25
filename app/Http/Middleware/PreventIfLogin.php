<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PreventIfLogin
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
        if (Auth::check()) {
            flash()->addError('Sayfa Erişilemez!', 'Hata');
            return redirect()->route('home')->with('message', 'Lütfen öncelikle mevcut oturumdan çıkış yapınız.');
        }
        return $next($request);
    }
}
