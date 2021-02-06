<?php 
namespace App\Http\Controllers\HomeClasses;

use App\Models\Contact;

class ContactManager{

	//save contact information from guest
	public function saveContact($data){
		$cont = new Contact;
		$cont->guest_name = $data['name'];
		$cont->guest_email = $data['email'];
		$cont->subject = $data['subject'];
		$cont->message = $data['message'];
		$cont->save();
	}
}

?>