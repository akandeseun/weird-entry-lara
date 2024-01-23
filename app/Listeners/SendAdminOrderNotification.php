<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\NewOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendAdminOrderNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        //TODO: make admin mail dynamic rather than hardcoding it
        $adminMail = env("ADMIN_MAIL");
        Notification::send($adminMail, new NewOrder($event->order));
    }
}
