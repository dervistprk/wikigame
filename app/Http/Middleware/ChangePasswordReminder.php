<?php

namespace App\Http\Middleware;

use Auth;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ChangePasswordReminder
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $password_change_time = Carbon::parse(Auth::user()->password_change_time);
        $now                  = Carbon::now();
        $difference           = $password_change_time->diffInMonths($now);

        if ($difference > 3) {
            return redirect()->route('admin.profile')->with('message', 'Şifrenizin süresi doldu. Lütfen şifrenizi değiştirin.');
        }

        return $next($request);
    }
}
