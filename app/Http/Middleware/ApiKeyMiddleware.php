<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('LARAFIFTEEN-API-KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'Clé API manquante'], 401);
        }

        $key = env("API_KEY");

        if ($apiKey != $key) {
            return response()->json(['error' => 'Clé API non valide'], 401);
        }

        // Vous pouvez également faire d'autres vérifications, comme vérifier les autorisations ou attacher l'utilisateur associé à la clé API.

        return $next($request);
    }
}
