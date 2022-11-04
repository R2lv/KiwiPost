<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $notiffication)
    {
        //
        $this->id = $notiffication->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->token = $user->email_token;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email verification') // todo translate
                    ->markdown('emails.email-verification')
                    ->with([
                        'name'=>$this->name,
                        'email'=>$this->email,
                        'url'=>'http://kiwipost.ge/email/verificaiton/'.$this->id.'/'.$this->token
                    ]);
    }
}
