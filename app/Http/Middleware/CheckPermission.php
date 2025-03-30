<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Add this use statement at the top

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user has the required permission
            if ($user->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        // Redirect or return an error response if the user doesn't have permission
        return abort(403, 'Unauthorized'); // You can customize the response as needed
    }
}
