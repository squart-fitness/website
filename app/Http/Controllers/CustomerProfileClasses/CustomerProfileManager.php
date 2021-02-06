<?php 
namespace App\Http\Controllers\CustomerProfileClasses;

use App\Http\Controllers\PaymentClasses\PaymentManager;
use App\Models\Customer;
use App\Models\Payment;

class CustomerProfileManager{

	//get a profile data of single customer
	public function getSingleProfile($d){
		$profile = Customer::find($d);
		return $profile;
	}

	//get payment detail of a single customer
	public function getPayment($id){
		$pay = new PaymentManager;
		return $pay->getSingleCustomerPayment($id);
	}
}



?>