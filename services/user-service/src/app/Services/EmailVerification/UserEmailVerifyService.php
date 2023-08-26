<?php

namespace App\Services\EmailVerification;

use App\Jobs\MailJob;
use App\Repositories\EmailVerification\impl\UserEmailVerifyRepositoryInterface;
use App\Services\EmailVerification\impl\UserEmailVerifyServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserEmailVerifyService implements UserEmailVerifyServiceInterface
{
    private UserEmailVerifyRepositoryInterface $userEmailVerifyRepository;
    public function __construct(UserEmailVerifyRepositoryInterface $userEmailVerifyRepository)
    {
        $this->userEmailVerifyRepository = $userEmailVerifyRepository;
    }
    public function sendEmailVerification($user)
    {
        return DB::transaction(function () use ($user){
            $token = Str::random(64);
            if ($this->userEmailVerifyRepository->createEmailVerifyToken($user->id, $token)){
                dispatch(new MailJob($user, $token))->onQueue('mail');
                return true;
            }
            return false;
        });
    }

    public function verifyEmail($token)
    {
        DB::transaction(function () use($token){
            $verifyUser = $this->userEmailVerifyRepository->getVerifyUser($token);
            if ($verifyUser){
                $user = $verifyUser->user;
                if (!$user->is_email_verified)
                {
                    $user->is_email_verified = true;
                    $user->save();
                    if ($this->userEmailVerifyRepository->deleteVerifyUser($user->id))
                    {
                        $message = 'Your Email is verified. You can now login.';
                    }
                    else{
                        $message = 'Something wrongs!';
                    }
                }
                else
                {
                    $message = "Your e-mail is already verified. You can now login.";
                }
                return ['message' => $message];
            }
            return null;
        });

    }
}
