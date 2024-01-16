<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;
    protected $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $url = null)
    {
        $this->order = $order;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Notification.')
            ->line('A new order has been placed!')
            ->line('Order Ref: ' . $this->order->order_reference)
            ->line('Total Amount: ₦' . $this->order->total)
            // ToDo: add action to view order
            // ->action('View Order', $this->url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
