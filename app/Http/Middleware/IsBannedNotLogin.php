<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsBannedNotLogin
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
        $user = User::find($request->segment(3));

        if ($user->isBanned()) {
            flash()->addError('Yasaklı Hesap!', 'Hata');
            return redirect()->route('login-form')->with('message', 'Bu hesap sitemizden yasaklanmıştır.');
        }
        return $next($request);
    }
}
