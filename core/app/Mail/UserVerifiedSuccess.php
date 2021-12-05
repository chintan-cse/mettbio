<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserVerifiedSuccess extends Mailable
{
    use Queueable, SerializesModels;
	public $userVerified;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userVerified)
    {
        //
		$this->userVerified = $userVerified;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verifyUserSuccess');
    }
}
