<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\GymEnquiry;
use Illuminate\Support\Facades\Mail;

class SendJoiningMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 100;
    public $timeout = 300;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $customerEmail, $mailObject;
    public function __construct($customerEmail, $mailObject)
    {
        $this->customerEmail = $customerEmail;
        $this->mailObject = $mailObject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->customerEmail)->send($this->mailObject); 
    }
}
