<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordField extends Mailable
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
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $data->password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password recovery')
                ->markdown('emails.password-field')
                ->with([
                    'name'=>$this->name,
                    'email'=>$this->email,
                    'password'=>$this->password
                ]);
    }
}
