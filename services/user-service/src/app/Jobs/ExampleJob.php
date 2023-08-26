<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

class ExampleJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('mail', ['token' => '123', 'name' => 'DC'], function($message) {
            $message->to('cddc76855@gmail.com')
                ->subject('Email verification!');
        });
    }
}
