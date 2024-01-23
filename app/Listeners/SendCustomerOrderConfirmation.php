<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\CustomerOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCustomerOrderConfirmation implements ShouldQueue
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
        Notification::send($event->order->user, new CustomerOrderNotification($event->order, $event->cart));
    }
}
