<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//custom imports
use App\Http\Controllers\SettingClasses\SettingManager;

class SettingController extends Controller
{
	public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
    }

    //show setting page
    public function showSettingPage(){
    	$sm = new SettingManager();
    	$emp_list = $sm->getEmployeeList();
    	return view('setting.app_setting')->with(['emp_list' => $emp_list]);
    }
}
