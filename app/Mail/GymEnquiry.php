<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GymEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $mailMessage;
    public function __construct($mailMessage)
    {
        $this->mailMessage = $mailMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailMessage->subject)
                    ->view('mails.lead.gym_enquiry_mail')
                    ->with('mailMessage', $this->mailMessage);
    }
}
