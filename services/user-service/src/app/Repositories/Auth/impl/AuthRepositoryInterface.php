<?php

namespace App\Repositories\Auth\impl;

interface AuthRepositoryInterface
{
    public function getUserByLogin($login);

    public function createUser($data);

    public function updateUserRefreshToken($userId, $token);
}
