<?php

namespace App\Notifications;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public Cart $cart;
    public Order $order;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, Cart $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
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
            ->subject('Order Confirmation.')
            ->greeting("Hello, {$notifiable->first_name}")
            ->line('Thank you for your order! Here are the details:')
            ->line('Order Reference: ' . $this->order->order_reference)
            ->line('Total Amount: ₦' . $this->order->subtotal)
            ->line('Delivery Fee: ₦' . $this->order->delivery_fee)
            ->line('Items:');

        // foreach ($this->cart->items as $item) {
        //     $message->line('- ' . $item['title'] . ' x ' . $item['quantity']);
        // }

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
