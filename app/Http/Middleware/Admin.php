<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $view = View::make('Front-end.page-404'); // Replace 'your.view' with the actual view name

        // Convert the view to a response
        $response = response($view);


        if(Auth()->user()->hasRole('admin'))
     {
     return $next($request);
     }

     return $response;


     }
}
