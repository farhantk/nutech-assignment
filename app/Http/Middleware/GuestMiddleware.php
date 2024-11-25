<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek autentikasi dengan JWT
        try {
            $token = $request->cookie('jwt_token'); 
            if ($token && JWTAuth::setToken($token)->authenticate()) {
                return redirect('/product'); 
            }
        } catch (JWTException $e) {
            return redirect('/signin')->with('error', 'Internal server error');
        }

        return $next($request);
    }
}
