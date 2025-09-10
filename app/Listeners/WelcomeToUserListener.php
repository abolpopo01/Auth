<?php

namespace App\Listeners;

use App\Events\UserRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\WelcomeMessMail;

class WelcomeToUserListener implements ShouldQueue
{
    use Queueable;
    /**
     * Handle the event.
     */
    public function handle(UserRegister $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeMessMail($event->user));
    }
}
