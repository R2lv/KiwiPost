<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $order)
    {

        $this->name = $user->name;
        $this->tracking = $order->tracking_number;
        $this->invoice = $order->xero_payment_url;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New order') // todo translate
            ->markdown('emails.new-order')
            ->with([
                'name'=>$this->name,
                'tracking'=>$this->tracking,
                'invoice'=>$this->invoice
            ]);
    }
}
