<?php

namespace App\Http\Middleware;

use App\Models\WhiteList;
use Closure;
use Illuminate\Http\Request;

class WhiteListMiddleware
{
    public $white_list;
    public $ips = [];

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
        $this->white_list = WhiteList::get()->toArray();

        foreach ($this->white_list as $white_list) {
            $this->ips[] = $white_list['ip'];
        }

        if (in_array($request->ip(), $this->ips)) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
