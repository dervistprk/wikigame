<?php

namespace App\Http\Middleware;

use App\Models\WhiteList;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WhiteListMiddleware
{
    public $white_list;
    public $ips = [];

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
