<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerifyEmail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Verify Your Email')
            ->view('emails.verify-email');
    }
}


