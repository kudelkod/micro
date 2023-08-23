<?php

namespace App\Repositories\EmailVerification;

use App\Models\UserEmailVerify;
use App\Repositories\EmailVerification\impl\UserEmailVerifyRepositoryInterface;

class UserEmailVerifyRepository implements UserEmailVerifyRepositoryInterface
{
    private UserEmailVerify $userEmailVerify;

    public function __construct(UserEmailVerify $userEmailVerify)
    {
        $this->userEmailVerify = $userEmailVerify;
    }

    public function createEmailVerifyToken($userId, $token)
    {
        return $this->userEmailVerify->create([
            'user_id' => $userId,
            'token' => $token,
        ]);
    }

    public function getVerifyUser($token)
    {
        return $this->userEmailVerify->where('token', $token)->first();
    }

    public function deleteVerifyUser($userId)
    {
        return $this->userEmailVerify->where('user_id', $userId)->delete();
    }
}
