<?php

namespace App\Http\Middleware;

use Auth;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChangePasswordReminder
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
        $password_change_time = Carbon::parse(Auth::user()->password_change_time);
        $now                  = Carbon::now();
        $difference           = $password_change_time->diffInMonths($now);

        if ($difference > 3) {
            flash()->addWarning('Şifre Süresi Doldu', 'Dikkat');
            return redirect()->route('admin.profile')->with('message', 'Şifrenizin süresi doldu. Lütfen şifrenizi değiştirin.');
        }

        return $next($request);
    }
}
