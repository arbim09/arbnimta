<?php

namespace App\Listeners;

use App\Mail\VerifyEmail;
use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerificationNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {

        $user = $event->user;
        Mail::to($user->email)->send(new VerifyEmail($user));
    }
}
