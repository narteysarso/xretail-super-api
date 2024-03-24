<?php

namespace App\Listeners;

use App\Events\PasswordResetEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ProcessMailing;

class EmailPasswordReset
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    /**
     * Handle the event.
     *
     * @param  PasswordResetEmail  $event
     * @return void
     */
    public function handle(PasswordResetEmail $event)
    {

        $staff = $event->staff;
        $password = $event->password;
        $subject = "Password Reset";
        $body = "Your new password is ";
        $body .= "password: {$password}\r\n";
        $config = [
            "toAddress" => $staff->email,
            "fromAddress" => "no-reply@mail.com"
        ];

        ProcessMailing::dispatch($subject, $body, $config);
    }
}
