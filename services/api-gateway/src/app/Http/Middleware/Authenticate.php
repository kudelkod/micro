<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $token = getTokenFromHeader($request);

        $token = validateToken($token);

        if (!$token)
        {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        try{
            $token = getAccessTokenData($token);
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
