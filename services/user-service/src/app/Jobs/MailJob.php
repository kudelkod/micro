<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

class MailJob extends Job
{
    private mixed $user;
    private mixed $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = url('/api/email/verify', ['token' => $this->token]);
        Mail::send('mail', ['url' => $url, 'name' => $this->user->name], function($message) {
            $message->to($this->user->email)
                ->subject('Email verification!');
        });
    }
}
