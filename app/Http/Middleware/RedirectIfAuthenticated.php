<?php
namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Check the role of the authenticated user
                $user = Auth::guard($guard)->user();

                if ($user->hasRole('client')) {
                  
                    return redirect(RouteServiceProvider::HOME); // Redirect others to the home route

                }
                return redirect()->route('dashboard'); // Redirect admins to the dashboard

            }
        }

        return $next($request);
    }
}
