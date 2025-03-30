<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserInteraction; // Assurez-vous que ce modèle existe
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogProductView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        // Vérifie si la route a un paramètre 'id'
        if ($request->route('id')) {
            $productId = $request->route('id');  // Récupère l'ID du produit dans l'URL

            // Enregistre l'interaction si l'utilisateur est authentifié
            if (Auth::check()) {
                UserInteraction::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'action_type' => 'view',  // Action de type 'view' pour une consultation
                    'interaction_time' => now(),  // Heure actuelle
                ]);
            }
        }

        return $next($request);  // Passe la requête à l'étape suivante
    }
    
}
