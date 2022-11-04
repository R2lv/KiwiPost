<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactSupport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->title = $data['title'];
        $this->text = $data['text'];

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SUPPORT')
            ->markdown('emails.support')
            ->replyTo($this->email)
            ->with([
                'email_from'=>$this->email,
                'name'=>$this->name,
                'title'=>$this->title,
                'text'=>$this->text,
            ]);
    }
}
