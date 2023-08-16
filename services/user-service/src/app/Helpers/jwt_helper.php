<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
function validateToken($token): mixed
{
    if (strlen($token) <= 7 || strtolower(substr($token, 0, 6)) != 'bearer'){
        return response()->json(['error' => "Invalid token" ], 200);
    }

    return $token;
}

function getTokenData($token): stdClass
{
    return JWT::decode(
        substr($token, 7),
        new Key(config('jwt.secret'), config('jwt.algorithm'))
    );
}

function getTokenFromHeader($request): string
{
    return $request->headers->get('Authorization') ?? '';
}
