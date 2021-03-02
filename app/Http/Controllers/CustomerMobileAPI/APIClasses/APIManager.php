<?php 
namespace App\Http\Controllers\CustomerMobileAPI\APIClasses;

// use App\Http\Controllers\GymClasses\GymManager;
// use App\Http\Controllers\AttendanceClasses\AttendanceManager;
// use App\Http\Controllers\PaymentClasses\PaymentManager;
// use App\Http\Controllers\CustomerClasses\CustomerManager;
// use App\Http\Controllers\DietPlanClasses\DietPlanManager;
// use App\Http\Controllers\WorkoutPlanClasses\WorkoutPlanManager;
use App\Http\Controllers\CustomerMobileAPI\APIClasses\APIDatabaseAccess;
use App\Models\Customer;

class APIManager{

	public function customerLogin($phone, $password){
		$member = Customer::where(['phone' => $phone, 'password' => base64_encode($password), 'status' => 1, 'is_deleted' => 1])->first();

		if(isset($member))
			return $member;
		else{
			return 0;
		}
	}

	//gym of a member joined
	public function getGym($id){
		$gymMan = new APIDatabaseAccess;
		$gymData =  $gymMan->getGym($id);

		if(isset($gymData)){
			return $gymData;
		}
		else{
			return 0;
		}
	}

	//get attendance report of a member
	public function getAttendanceReport($id){
		$atm = new APIDatabaseAccess;
		$report = $atm->getFullAttedanceReportById($id);

		if(isset($report)){
			return $report;
		}
		else{
			return 0;
		}
	}

	// make attendance of member in a gym
	public function makeAttendance($date, $gymUsername, $customerID){
		$atm = new APIDatabaseAccess;
		$result = $atm->setAttendanceFromAPI($date, $gymUsername, $customerID);

		return $result;
	}

	//get payment detail of a single customer
	public function getPayment($id){
		$pay = new APIDatabaseAccess;
		$payments = $pay->getSingleCustomerPayment($id);

		if(!empty($payments) && isset($payments)){
			return $payments;
		}
		else{
			return 0;
		}
	}

	//change current status of customer of a gym
	public function changeCurrentStatus($status, $password, $gym_id, $customer_id){
		$temp_stat = $status;
		if($status === 1){
			$temp_stat = 0;
		}
		else{
			$temp_stat = 1;
		}

		$res = Customer::where(['gym_id' => $gym_id, 'id' => $customer_id, 'is_deleted' => 1, 'password' => base64_encode($password)])
						->update(['status' => $temp_stat]);
		
		return $res;
	}

	//update customer information 
	public function updateCustomer($data){
		$cm = new APIDatabaseAccess;
		$result = $cm->apiUpdateCustomerInfo($data);
		return $result;
	}

	//give diets of a customer
	public function customerDiet($gym_id, $customer_id){
		$dpm = new APIDatabaseAccess;
		$result = $dpm->memberAllDiet($gym_id, $customer_id);
		return $result;
	}

	//give wokrout of a customer
	public function customerWorkout($gym_id, $customer_id){
		$wpm = new APIDatabaseAccess;
		$result = $wpm->memberAllWorkout($gym_id, $customer_id);
		return $result;
	}

	//save social to database
	public function saveSocial($data, $gym_id, $customer_id){
		$cm = new APIDatabaseAccess;
		$result = $cm->saveSocialLinks($data, $gym_id, $customer_id);
		return $result;
	}

	//update customer image
	public function imageUpdate($data, $gym_id, $customer_id){
		$cm = new APIDatabaseAccess;
		$result = $cm->updateCustomerImage($data, $gym_id, $customer_id);
		return $result;
	}

	//change password 
	public function changePassword($data, $gym_id, $customer_id){
		$member = Customer::where(['id' => $customer_id, 'password' => base64_encode($data['old_password']), 'status' => 1, 'is_deleted' => 1])->first();

		if(isset($member)){
			$member->password = base64_encode($data['new_password']);
			$res = $member->update();
			return $res;
		}
		else{
			return 0;
		}
	}


	//get notifications for customers
	public function showNotification($gym_id, $customer_id){
		$adb = new APIDatabaseAccess();
		$result = $adb->getNotification($gym_id, $customer_id);
		return $result;
	}

	//get all batches for a gym
	public function showBatches($gym_id){
		$adb = new APIDatabaseAccess();
		return $adb->getBatches($gym_id);
	}


	//get all packages for a gym
	public function showPackages($gym_id){
		$adb = new APIDatabaseAccess();
		return $adb->getPackages($gym_id);
	}

	//show customer rating 
	public function showRating($gym_id, $customer_id){
		$adb = new APIDatabaseAccess();
		return $adb->getCustomerRating($gym_id, $customer_id);
	}

	//set gym rating
	public function ratingToGym($data, $gym_id, $customer_id){
		$adb = new APIDatabaseAccess;
		$result = $adb->setGymRating($data, $gym_id, $customer_id);
		return $result;
	}

	//customer freezing history
	public function customerFreezingHistory($gym_id, $customer_id){
		$adb = new APIDatabaseAccess();
		$result = $adb->getFreezingHistory($gym_id, $customer_id);
		return $result;
	}
}

 ?>