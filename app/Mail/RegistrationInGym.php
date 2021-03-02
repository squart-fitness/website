<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationInGym extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $transfer_info;
    public function __construct($transfer_info)
    {
        $this->transfer_info = $transfer_info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->transfer_info->subject)
        			->view('mails.lead.registration')
        			->with('transfer_info', $this->transfer_info);
    }
}
