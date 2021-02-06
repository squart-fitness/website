<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CustomerProfileClasses\CustomerProfileManager;

class CustomerProfileController extends Controller
{
    public function __construct(){
    	$this->middleware(['gymstatus', 'auth']);
    }

    //show customer profile page
    public function showProfile($id){
    	$cpm = new CustomerProfileManager;
    	$profile = $cpm->getSingleProfile((int)$id);
        $payment = $cpm->getPayment((int)$id);
    	// return $profile;
    	return view('customer.customer_profile')->with(['profile' => $profile, 'pay' => $payment]);
    }


}
