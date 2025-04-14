<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Vérifie la validité du token JWT et authentifie l'utilisateur
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Le token a expiré.'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Le token est invalide.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token non trouvé.'], 401);
        }

        // Auth::user() fonctionnera correctement après cette ligne
        auth()->setUser($user);

        return $next($request);
    }
}
