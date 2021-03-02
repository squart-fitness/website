<?php 
namespace App\Http\Controllers\MailHandlerClasses;

use Illuminate\Support\Facades\Mail;

use App\Mail\RegistrationInGym;
use App\Mail\GymEnquiry;

class MailManager{

	//sending mail after customer gets a member of a gym
	public function sendRegistrationMail($gymName, $gymEmail, $gymPhone, $customerPhone, $customerEmail, $customerPassword){
		$message = new \stdClass;
        $message->subject = "Registed in ".ucfirst($gymName);
        $message->body = "Welcome to our gym.";
        $message->gym_email = $gymEmail;
        $message->gym_phone = $gymPhone;
        $message->customer_phone = $customerPhone;
        $message->customer_email = $customerEmail;
        $message->customer_password = $customerPassword;

        Mail::to($customerEmail)->queue(new RegistrationInGym($message));

	}

	//sending mail after a person makes a enquiry in a gym
	public function sendEnquiryMail($gymName, $gymEmail, $gymPhone, $customerEmail){
		$message = new \stdClass;
        $message->subject = "Made Enquiry in ".ucfirst($gymName);
        $message->body = "Thanks to visit our gym! Hope you come again.";
        $message->gym_email = $gymEmail;
        $message->gym_phone = $gymPhone;
        $message->customer_email = $customerEmail;
        
        Mail::to($customerEmail)->queue(new GymEnquiry($message));	
	}
}