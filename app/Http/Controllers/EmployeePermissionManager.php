<?php 
namespace App\Http\Controllers;

use App\Models\Employee;
use Session;

class EmployeePermissionManager{

	public static function initializeFeatures(){
		$emp = Employee::where(['id' => auth('employee')->user()->id, 'status' => 1, 'is_deleted' => 1])
						->first()
						->getApplicationFeatures;

		$app_features = array();
		foreach ($emp as $value) {
			array_push($app_features, $value->features);
		}

		Session::put('app_features', $app_features);
		Session::save();
	}
}