<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class JWTAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->headers->get('Authorization') ?? '';

        if (strlen($token) <= 7 || strtolower(substr($token, 0, 6)) != 'bearer'){
            return response()->json(['message' => 'Пользователь не авторизован']);
        }
    }
}
