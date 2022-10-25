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
            $route = route('resend-verification');
            flash()->addWarning('Üyelik Onayı Bekleniyor.', 'Dikkat!');
            return redirect()->route('login-form')
                             ->with(
                                 'message',
                                 'Üyeliğiniz henüz onaylanmadı. Üyeliğiniz ile giriş yapabilmek için lütfen e-posta hesabınıza gönderilen onay linkine tıklayın.
                                  <br>Doğrulama postasını almadınız mı? Tekrar göndermek için lütfen
                                  <a class="link-primary text-decoration-none" href="' . $route . '">tıklayın</a>.'
                             );
        }
        return $next($request);
    }
}
