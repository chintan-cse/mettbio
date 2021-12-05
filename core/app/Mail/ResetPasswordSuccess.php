<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordSuccess extends Mailable
{
    use Queueable, SerializesModels;
	public $resetsuccess;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resetsuccess)
    {
        //
		$this->resetsuccess = $resetsuccess;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password Reset Successfully')->view('emails.passwordResetSuccess');
    }
}
