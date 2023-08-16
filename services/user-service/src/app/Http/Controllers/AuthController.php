<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register']]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('login', 'password');

        if (!Auth::attempt($credentials)){
            return response()->json(['error' => 'Invalid login or password'], 200);
        }

        $user = Auth::user();

        $access_token = $this->createAccess($user);
        $refresh_token = $this->createRefresh($user);

        $user->update([
            'refresh_token' => $refresh_token,
        ]);
        return response()->json(['access_token' => $access_token, 'refresh_token' => $refresh_token], 200);
    }

    public function register(Request $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'login' => $request->login,
            'password' => Hash::make($request->password),
        ]);

        $access_token = $this->createAccess($user);
        $refresh_token = $this->createRefresh($user);

        $user->update([
            'refresh_token' => $refresh_token,
        ]);

        return response()->json(['access_token' => $access_token, 'refresh_token' => $refresh_token], 200);
    }

    public function me(Request $request): JsonResponse
    {
        $token = getTokenFromHeader($request);

        $token = getTokenData($token);

        return response()->json($token->sub);
    }
    protected function createAccess($user): string
    {
        $payload_access = [
            'aud' => 'user-service',
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $user,
        ];

        return JWT::encode($payload_access, config('jwt.secret'), config('jwt.algorithm'));
    }

    protected function createRefresh($user): string
    {
        $payload_refresh = [
            'aud' => 'user-service',
            'iat' => time(),
            'exp' => time() + 2678400,
            'sub' => $user,
        ];

        return JWT::encode($payload_refresh, config('jwt.secret'), config('jwt.algorithm'));
    }
}
