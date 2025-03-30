<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoFactorMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
    
        // Skip 2FA check for setup and secret generation routes
        if ($request->routeIs('2fa.setup', '2fa.generate.secret')) {
            return $next($request);
        }
    
        // Rediriger vers la vérification si 2FA est activé mais pas encore validé
        if ($user && $user->google2fa_secret && !Session::get('2fa_verified')) {
            return redirect()->route('2fa.verify.form');
        }
    
        return $next($request);
    }
    

}