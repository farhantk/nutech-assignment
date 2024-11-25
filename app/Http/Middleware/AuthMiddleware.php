<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->cookie('jwt_token');
            if (!$token) {
                return redirect('/signin')->with('error', 'Token not found.');
            }

            if (substr_count($token, '.') !== 2) {
                return redirect('/signin')->with('error', 'Invalid token format.');
            }

            JWTAuth::setToken($token)->authenticate();
        } catch (JWTException $e) {
            return redirect('/signin')->with('error', 'Unauthorized: ' . $e->getMessage());
        }

        return $next($request);
    }
}
