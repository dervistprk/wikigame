<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IsVerifyEmail
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
        if (!Auth::user()->isVerified()) {
            Auth::logout();
            flash()->addWarning(__('Üyelik Onayı Bekleniyor.'), __('Dikkat'));
            return redirect()->route('login-form')
                             ->with(
                                 'message',
                                 trans('messages.waiting_membership_approval')
                             );
        }
        return $next($request);
    }
}
