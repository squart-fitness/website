<?php 
namespace App\Http\Controllers\SettingClasses;

use App\Http\Controllers\Employee\EmployeeClasses\EmployeeManager;

class SettingManager{

	//get employee list
	public function getEmployeeList(){
		$em = new EmployeeManager();
		$emp_list = $em->getActiveEmployees();
		return $emp_list;
	}
}