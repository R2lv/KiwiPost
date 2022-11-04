<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordRecovery extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $data)
    {
        //
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->token = $data->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password recovery')
                    ->markdown('emails.password-recovery')
                    ->with([
                        'name'=>$this->name,
                        'email'=>$this->email,
                        'url'=>'https://kiwipost.ge/password/recovery/'.$this->id.'/'.$this->token
                    ]);
    }
}
