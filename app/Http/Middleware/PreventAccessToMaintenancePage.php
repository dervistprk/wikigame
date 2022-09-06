<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class PreventAccessToMaintenancePage
{
    public $site_settings;

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
        $this->site_settings = Setting::find(1);

        if ($this->site_settings->site_status != 0 && $request->segment(1) == 'bakimdayiz') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
