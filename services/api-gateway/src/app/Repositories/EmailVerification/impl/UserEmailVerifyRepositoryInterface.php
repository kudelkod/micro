<?php

namespace App\Repositories\EmailVerification\impl;

interface UserEmailVerifyRepositoryInterface
{
    public function createEmailVerifyToken($userId, $token);

    public function getVerifyUser($token);

    public function deleteVerifyUser($userId);
}
