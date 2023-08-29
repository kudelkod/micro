<?php

namespace App\Services\Auth\impl;

interface AuthServiceInterface
{
    public function signInUserByCredentials($credentials);

    public function registerUser($data);

    public function refreshUserToken($refresh_token);
}
