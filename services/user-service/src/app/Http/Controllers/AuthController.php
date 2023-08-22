<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register', 'mail']]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('login', 'password');
        $data = DB::transaction(function () use ($credentials){
            $user = User::where('login', $credentials['login'])->first();

            if (!$user){
                return response()->json(['error' => 'Invalid login'], 200);
            }
            if (!Hash::check($credentials['password'], $user->password)){
                return response()->json(['error' => 'Invalid password'], 200);
            }

            $access_token = $this->createAccess($user);
            $refresh_token = $this->createRefresh($user);

            $user->update([
                'refresh_token' => $refresh_token,
            ]);

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
        });
        return response()->json($data, 200);
    }

    public function register(Request $request): JsonResponse
    {
        $data = DB::transaction(function () use ($request){
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

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
        });

        return response()->json($data, 200);
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

        return JWT::encode($payload_access, env('JWT_SECRET'), env('JWT_ALGORITHM'));
    }

    protected function createRefresh($user): string
    {
        $payload_refresh = [
            'aud' => 'user-service',
            'iat' => time(),
            'exp' => time() + 2678400,
            'sub' => $user,
        ];

        return JWT::encode($payload_refresh, env('JWT_SECRET'), env('JWT_ALGORITHM'));
    }

    public function mail(){
        $data = array('name'=>'DC');
        Mail::send('mail', $data, function($message) {
            $message->to('cddc76855@gmail.com')->subject('Test Mail from Dima');
        });
    }
}
