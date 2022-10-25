<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PreventAccessToMaintenancePage
{
    public $site_settings;

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
        $this->site_settings = Setting::find(1);

        if ($this->site_settings->site_status != 0 && $request->segment(1) == 'bakimdayiz') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
