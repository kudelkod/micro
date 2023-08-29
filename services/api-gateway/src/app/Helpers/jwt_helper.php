<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
function validateToken($token): mixed
{
    if (strlen($token) <= 7 || strtolower(substr($token, 0, 6)) != 'bearer'){
        return null;
    }

    return $token;
}

function getAccessTokenData($token): stdClass
{
    return JWT::decode(
        substr($token, 7),
        new Key(env('JWT_SECRET'), env('JWT_ALGORITHM'))
    );
}

function getRefreshTokenData($token): stdClass
{
    return JWT::decode(
        $token,
        new Key(env('JWT_SECRET'), env('JWT_ALGORITHM'))
    );
}

function getTokenFromHeader($request): string
{
    return $request->headers->get('Authorization') ?? '';
}
