<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountConfirmation extends Mailable
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
        return $this->view('mail.account_confirmation')->with([
            'token' => $this->token,
            'user'  => $this->user
        ]);
    }
}
