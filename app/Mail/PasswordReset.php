<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $token, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user) {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('mail.reset_password')->with([
            'token' => $this->token,
            'user'  => $this->user
        ]);
    }
}
