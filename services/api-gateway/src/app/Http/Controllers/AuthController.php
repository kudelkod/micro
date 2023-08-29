<?php

namespace App\Http\Controllers;

use App\Services\Auth\impl\AuthServiceInterface;
use App\Services\EmailVerification\impl\UserEmailVerifyServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;
    private UserEmailVerifyServiceInterface $userEmailVerifyService;
    public function __construct(
        AuthServiceInterface $authService,
        UserEmailVerifyServiceInterface $userEmailVerifyService,
    )
    {
        $this->authService = $authService;
        $this->userEmailVerifyService = $userEmailVerifyService;
        $this->middleware('auth', ['except' => ['login', 'register', 'refresh']]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('login', 'password');
        $response = $this->authService->signInUserByCredentials($credentials);

        if ($response){
            return response()->json($response, 200);
        }

        return response()->json(['message' => 'Not signed in'], 200);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->input();
        $result = $this->authService->registerUser($data);

        if($result){
            return response()->json(['message' => 'Email for verification send!'], 200);
        }

        return response()->json(['message' => 'Not registered'], 200);
    }

    public function refresh(Request $request): JsonResponse
    {
        $refresh_token = $request->refresh_token ?? null;
        $response = $this->authService->refreshUserToken($refresh_token);

        return response()->json($response, 200);
    }
}
