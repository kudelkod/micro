<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        $token = getTokenFromHeader($request);
        $token = getAccessTokenData($token);

        return response()->json($token->sub);
    }
}
