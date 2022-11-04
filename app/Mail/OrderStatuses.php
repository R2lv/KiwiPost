<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatuses extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $message)
    {
        $this->name = $order->user->name;
        $this->tracking = $order->tracking_number;
        $this->status = $order->status;
        $this->invoice = $order->xero_payment_url;
        $this->message = $message;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Status Update') // todo translate
        ->markdown('emails.order-satuses')
            ->with([
                'name'=>$this->name,
                'tracking'=>$this->tracking,
                'message'=>$this->message
            ]);
    }
}

