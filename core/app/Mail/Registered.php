<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Registered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company,$email,$password)
    {
		$this->company = $company;
		$this->email = $email;
		$this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registered')
                ->replyTo($this->email)
				->subject("Registration Mail")
				->with(['company'=>$this->company,'email'=>$this->email,'password'=>$this->password]);
    }
}
