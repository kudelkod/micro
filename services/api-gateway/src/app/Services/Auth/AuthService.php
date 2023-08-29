<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\impl\AuthRepositoryInterface;
use App\Repositories\EmailVerification\impl\UserEmailVerifyRepositoryInterface;
use App\Services\Auth\impl\AuthServiceInterface;
use App\Services\EmailVerification\impl\UserEmailVerifyServiceInterface;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    private AuthRepositoryInterface $authRepository;
    private UserEmailVerifyServiceInterface $userEmailVerifyService;

    public function __construct(
        AuthRepositoryInterface $authRepository,
        UserEmailVerifyServiceInterface $userEmailVerifyService,
    )
    {
        $this->authRepository = $authRepository;
        $this->userEmailVerifyService = $userEmailVerifyService;
    }

    public function signInUserByCredentials($credentials): mixed
    {
        return DB::transaction(function () use ($credentials){
            $user = $this->authRepository->getUserByLogin($credentials['login']);

            if (!$user){
                return ['error' => 'Invalid login'];
            }
            if (!Hash::check($credentials['password'], $user->password)){
                return ['error' => 'Invalid password'];
            }

            $access_token = $this->createAccess($user);
            $refresh_token = $this->createRefresh($user);

            return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
        });
    }

    public function registerUser($data): mixed
    {
        return DB::transaction(function () use ($data){
            $user = $this->authRepository->createUser($data);
            $mail = $this->userEmailVerifyService->sendEmailVerification($user);
            if ($mail)
            {
                return true;
            }
            return null;
        });
    }

    public function refreshUserToken($refresh_token): array
    {
        try{
            $token = getRefreshTokenData($refresh_token);
            if ($token->exp < time())
            {
                throw new \Exception();
            }
        }
        catch (\Throwable $e){
            return ['error' => 'Token expired'];
        }

        $access_token = $this->createAccess($token->sub);
        $refresh_token = $this->createRefresh($token->sub);

        return ['access_token' => $access_token, 'refresh_token' => $refresh_token];
    }

    private function createAccess($user): string
    {
        $payload_access = [
            'aud' => 'user-service',
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $user,
        ];

        return JWT::encode($payload_access, env('JWT_SECRET'), env('JWT_ALGORITHM'));
    }

    private function createRefresh($user): string
    {
        $payload_refresh = [
            'aud' => 'user-service',
            'iat' => time(),
            'exp' => time() + 2678400,
            'sub' => $user,
        ];

        return JWT::encode($payload_refresh, env('JWT_SECRET'), env('JWT_ALGORITHM'));
    }
}
