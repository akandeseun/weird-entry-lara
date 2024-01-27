<?php

namespace App\Jobs;

use App\Mail\NewOrder;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyAdminAndCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $pdf = Pdf::loadView('pdf.receipt', ['order' => $this->order])->output();

        Mail::to($this->order->user)->send(new OrderConfirmation($this->order, $pdf));

        Mail::to(env("ADMIN_MAIL"))->send(new NewOrder($this->order));
    }
}
