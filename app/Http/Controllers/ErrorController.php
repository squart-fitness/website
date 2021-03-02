<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
	public function __construct(){
    	$this->middleware(['auth:web,employee']);
	}

    //account deactivated error function
    public function accountDeactivated(){
    	$errorName = "Gym Deactivated";
    	$title = "No load";
    	$message = "Your Gym account is deactivated from using the service. Contact us for re-activation of account.";
    	return view('errors.error')->with(['name' => $errorName, 'title' => $title, 'message' => $message]);
    }
}
