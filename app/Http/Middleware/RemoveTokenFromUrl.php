<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveTokenFromUrl
{
    /**
     * Remove some attributes which makes some confusion.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->get('_token')) {
            return $this->removeFromQueryAndRedirect($request, '_token');
        }
        return $next($request);
    }

    /**
     * Remove and make redirection.
     *
     * @param Request $request
     * @param  string $parameter
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromQueryAndRedirect(Request $request, string $parameter)
    {
        $request->query->remove($parameter);
        return redirect()->to($request->fullUrlWithQuery([]));
    }
}
