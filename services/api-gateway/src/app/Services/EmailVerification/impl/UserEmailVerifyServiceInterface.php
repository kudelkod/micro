<?php

namespace App\Services\EmailVerification\impl;

interface UserEmailVerifyServiceInterface
{
    public function sendEmailVerification($user);

    public function verifyEmail($token);
}
