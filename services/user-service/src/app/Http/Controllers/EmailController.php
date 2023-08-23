<?php

namespace App\Http\Controllers;

use App\Services\EmailVerification\impl\UserEmailVerifyServiceInterface;

class EmailController extends Controller
{
    private UserEmailVerifyServiceInterface $userEmailVerifyService;

    public function __construct(UserEmailVerifyServiceInterface $userEmailVerifyService)
    {
        $this->userEmailVerifyService = $userEmailVerifyService;
    }

    public function verify($token)
    {
        $response = $this->userEmailVerifyService->verifyEmail($token);

        return response()->json($response, 200);
    }
}
