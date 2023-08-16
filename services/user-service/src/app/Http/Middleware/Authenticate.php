<?php

namespace App\Http\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, \Closure $next){
        $token = getTokenFromHeader($request);

        $token = validateToken($token);
        try{
            $token = getTokenData($token);
            if ($token->exp < time())
            {
                throw new \Exception();
            }
        }
        catch (\Throwable $e){
            return response()->json(['error' => 'Token expired'], 200);
        }

        return $next($request);
    }
}
