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
            flash()->addError(__('Sayfa Erişilemez'), __('Hata'));
            return redirect()->route('home')->with('message', __('Lütfen öncelikle mevcut oturumdan çıkış yapınız.'));
        }
        return $next($request);
    }
}
