<?php

namespace App\Listeners;

use App\Events\NewStaffRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ProcessMailing;

class EmailWelcomeNotification
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
     * @param  NewStaffRegistered  $event
     * @return void
     */
    public function handle(NewStaffRegistered $event)
    {
        //
        $staff = $event->staff;
        $password = $event->password;
        $user = $event->user;
        $subject = "Invitation to Invoice App";
        $body = "You have been invited to use <a href='http://localhost:8000'>Invoice service</a> by {$user->email} \r\n";
        $body .= "email: {$staff->email}\r\n";
        $body .= "password: {$password}\r\n";
        $config = [
            "toAddress" => $staff->email,
            "fromAddress" => "no-reply@mail.com"
        ];

        ProcessMailing::dispatch($subject, $body, $config);
    }
}
