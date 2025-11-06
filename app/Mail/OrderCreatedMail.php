<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing('items');
    }

    public function build(): self
    {
        return $this
            ->subject('Pesanan Baru #' . $this->order->order_number)
            ->markdown('emails.orders.created', [
                'order' => $this->order,
            ]);
    }
}
