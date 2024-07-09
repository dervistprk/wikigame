<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class isLoginUser
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
            return $next($request);
        }

        flash()->addError(__('Sayfa Erişilemez'), __('Hata'));
        return redirect()->route('login-form')->with('message', __('Gitmek istediğiniz sayfayı görebilmek için giriş yapmanız gerekmektedir.'));
    }
}
