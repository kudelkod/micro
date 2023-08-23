<?php

namespace App\Providers;

use App\Repositories\EmailVerification\impl\UserEmailVerifyRepositoryInterface;
use App\Repositories\EmailVerification\UserEmailVerifyRepository;
use App\Services\EmailVerification\impl\UserEmailVerifyServiceInterface;
use App\Services\EmailVerification\UserEmailVerifyService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserEmailVerifyServiceInterface::class, function ($app){
            return $app->make(UserEmailVerifyService::class);
        });

        $this->app->singleton(UserEmailVerifyRepositoryInterface::class, function ($app){
            return $app->make(UserEmailVerifyRepository::class);
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
