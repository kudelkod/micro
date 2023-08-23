<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Auth\impl\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserByLogin($login)
    {
        return $this->user->where('login', $login)->first();
    }

    public function createUser($data)
    {
        return $this->user->create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateUserRefreshToken($userId, $token)
    {
        $user = $this->user->find($userId);
        return $user->update(['refresh_token' => $token]);
    }
}
