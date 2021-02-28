<?php 
namespace App\Http\Controllers\CustomerMobileAPI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// import inside application
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Controllers\CustomerMobileAPI\APIClasses\APIManager;

class APIController extends Controller{

	private $apiKey = 'diekd83JHsdsd5sSDf';
	private $usages = 'desktop';

	public function __construct(){
		$this->middleware('api');
		$this->middleware('checkmemberlogin')->except('login');
		// $this->middleware('auth.basic');
	}

	//customer login to database
	public function login(Request $request){
		$validator = Validator::make(
										[
											'password' => $request->password,
										 	'phone' => $request->phone,
										],

										[
											'password' => ['required', 'string', 'min:4', 'max:50'],
											'phone' => ['required', 'string', 'digits:10'], 
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Phone number or password is invalid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$member = $apiMan->customerLogin($request->phone, $request->password);
		if($member !== 0){
			return json_encode($member, 200);
		}
		else{
			$error = array('title' => 'Wrong credentials', 'message' => 'Phone number or password does not match', 'response_code' => 401);
			return json_encode($error, 401);
		}
	}

	//get member's gym in which they joined
	public function memberJoinedGym(Request $request){
		$id = $request->route('gym_id');
		$validator = Validator::make(['id' => $id], ['id' => ['required', 'numeric']]);

		if($validator->fails()){
			$error = array('title' => 'Invalid GYM ID', 'message' => 'The gym id provided is not valid.');
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$gym = $apiMan->getGym((int)$id);
		if($gym !== 0){
			return json_encode($gym, 200);
		}
		else{
			$error = array('title' => 'Not found', 'message' => 'Gym not found. Something went worng');
			return json_encode($error, 404);
		}
	}

	//get attendance of a member
	public function getAttendance(Request $request){
		$customer_id = $request->route('customer_id');
		$validator = Validator::make(['id' => $customer_id], ['id' => ['required', 'numeric']]);

		if($validator->fails()){
			$error = array('title' => 'Invalid Member ID', 'message' => 'The member id provided is not valid.');
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$attendance = $apiMan->getAttendanceReport((int)$customer_id);
		if($attendance !== 0){
			return json_encode($attendance, 200);
		}
		else{
			$error = array('title' => 'Not found', 'message' => 'Attendance not found. Something went worng');
			return json_encode($error, 404);
		}
	}


	//get payment detail of a member
	public function getPayment(Request $request){
		$customer_id = $request->route('customer_id');
		$validator = Validator::make(['id' => $customer_id], ['id' => ['required', 'numeric']]);

		if($validator->fails()){
			$error = array('title' => 'Invalid Member ID', 'message' => 'The member id provided is not valid.');
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$pays = $apiMan->getPayment((int)$customer_id);
		if($pays !== 0){
			return json_encode($pays, 200);
		}
		else{
			$error = array('title' => 'Not found', 'message' => 'Payment detail not found. Something went worng');
			return json_encode($error, 404);
		}
	}


	//create attendance of customer in a gym
	public function createAttendance(Request $request, $gym_username, $customer_id){
		$validator = Validator::make(
										[
											'date' => $request->attendance_date,
											'gym_username' => $gym_username,
											'id' => $customer_id,
										],

										[
											'date' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
											'gym_username' => ['required', 'alpha_num'],
											'id' => ['required', 'numeric'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Date format, gym username or customer id is invalid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$res = $apiMan->makeAttendance($request->attendance_date, $gym_username, $customer_id);
		if($res === -1){
			$msg = array('title' => 'Fail', 'message' => 'Attendance already created for the day', 'response_code' => 201);
			return json_encode($msg, 201);
		}

		if($res !== 0){
			$msg = array('title' => 'Success', 'message' => 'Attendance has been created', 'response_code' => 200);
			return json_encode($msg, 200);
		}
		else{
			$error = array('title' => 'Error', 'message' => 'Something went wrong', 'response_code' => 401);
			return json_encode($error, 401);
		}
	}

	//change status of customer of a gym
	public function changeCustomerStatus(Request $request, $gym_id, $customer_id){
		$validator = Validator::make(
										[
											'status' => $request->status,
											'password' => $request->password,
											'gym_id' => $gym_id,
											'id' => $customer_id,
										],

										[
											'status' => ['required', 'numeric'],
											'password' => ['required', 'string', 'min:4', 'max:50'],
											'gym_id' => ['required', 'numeric'],
											'id' => ['required', 'numeric'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Status format is not valid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$res = $apiMan->changeCurrentStatus((int)$request->status, $request->password, $gym_id, $customer_id);
		
		if($res !== 0){
			$msg = array('title' => 'Success', 'message' => 'Your Account from the gym has been deactivated', 'response_code' => 200);
			return json_encode($msg, 200);
		}
		else{
			$error = array('title' => 'Invalid input', 'message' => 'Password is not valid', 'response_code' => 401);
			return json_encode($error, 401);
		}
	}


	//update member information in a gym
	public function updateInformation(Request $request, $gym_id, $customer_id){
		$validator = Validator::make(
										[
											'gym_id' => $gym_id,
											'customer_id' => $customer_id,
											'phone' => $request->phone,
											'email' => $request->email,
											'dob' => $request->dob,
											'gender' => $request->gender,
											'height' => $request->height,
											'weight' => $request->weight,
											'goal' => $request->goal,
											'address' => $request->address,
										],

										[
											'gym_id' => ['required', 'numeric'],
											'customer_id' => ['required', 'numeric'],
		    								'phone' => ['required', 'numeric', 'digits:10'],
		    								'email' => ['nullable', 'email', 'string', 'max:255'],
		    								'goal' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s]+$/', 'max:255'],
					    					'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/]+$/', 'max:255'],
		                                    'gender' => ['required', 'alpha', 'max:100'],
		                                    'dob' => ['nullable', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
		                                    'height' => ['nullable', 'regex:/^[\w\s\.]+$/'],
		                                    'weight' => ['nullable', 'regex:/^[\w\s\.]+$/'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Any edited field is invalid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$data = array(
						'gym_id' => $gym_id,
						'customer_id' => $customer_id,
						'phone' => $request->phone,
						'email' => $request->email,
						'dob' => $request->dob,
						'gender' => $request->gender,
						'height' => $request->height,
						'weight' => $request->weight,
						'goal' => $request->goal,
						'address' => $request->address,

					);

		$apiMan = new APIManager;
		$res = $apiMan->updateCustomer($data);	

		if($res !== 0){
			$msg = array('title' => 'Success', 'message' => 'Your information has been updated', 'response_code' => 200);
			return json_encode($msg, 200);
		}
		else{
			$error = array('title' => 'Failed', 'message' => 'Something went wrong! Information has not been updated', 'response_code' => 401);
			return json_encode($error, 401);
		}	

	}

	//get customer diet
	public function showCustomerDiet($gym_id, $customer_id){
		$validator = Validator::make(
										[
											'gym_id' => $gym_id,
											'id' => $customer_id,
										],

										[
											'gym_id' => ['required', 'numeric'],
											'id' => ['required', 'numeric'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Data is not valid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$res = $apiMan->customerDiet($gym_id, $customer_id);
		
		if(count($res) > 0){
			return json_encode($res, 200);
		}
		else{
			$error = array('title' => 'Not found', 'message' => 'No diet plan is available for this member', 'response_code' => 401);
			return json_encode($error, 401);
		}
	}

	//get customer workout
	public function showCustomerWorkout($gym_id, $customer_id){
		$validator = Validator::make(
										[
											'gym_id' => $gym_id,
											'id' => $customer_id,
										],

										[
											'gym_id' => ['required', 'numeric'],
											'id' => ['required', 'numeric'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Data is not valid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$apiMan = new APIManager;
		$res = $apiMan->customerWorkout($gym_id, $customer_id);
		
		if(count($res) > 0){
			return json_encode($res, 200);
		}
		else{
			$error = array('title' => 'Not found', 'message' => 'No diet plan is available for this member', 'response_code' => 401);
			return json_encode($error, 401);
		}
	}

	//save social links 
	public function saveSocialLink(Request $request){
		$gymID = $request->route('gym_id');
		$customerID = $request->route('customer_id');

		$validator = Validator::make(
										[
											'gym_id' => $gymID,
											'id' => $customerID,
											'facebook' => $request->facebook,
											'instagram' => $request->instagram,
											'twitter' => $request->twitter,
										],

										[
											'gym_id' => ['required', 'numeric'],
											'id' => ['required', 'numeric'],
											'facebook' => ['nullable', 'string', 'max:200'],
											'instagram' => ['nullable', 'string', 'max:200'],
											'twitter' => ['nullable', 'string', 'max:200'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Data is not valid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$data = array(
						'facebook' => $request->facebook,
						'instagram' => $request->instagram,
						'twitter' => $request->twitter,
					);

		$apiMan = new APIManager;
		$res = $apiMan->saveSocial($data, $gymID, $customerID);
		
		if($res !== 0){
			$msg = array('title' => 'Success', 'message' => 'Your information has been saved', 'response_code' => 200);
			return json_encode($msg, 200);
		}
		else{
			$error = array('title' => 'Failed', 'message' => 'Something went wrong! Information has not been saved', 'response_code' => 401);
			return json_encode($error, 401);
		}	
	}

	//customer image update
	public function customerImageUpdate(Request $request){
		$gymID = $request->route('gym_id');
		$customerID = $request->route('customer_id');

		$validator = Validator::make(
										[
											'gym_id' => $gymID,
											'id' => $customerID,
											'customer_image' => $request->customer_image,
										],

										[
											'gym_id' => ['required', 'numeric'],
											'id' => ['required', 'numeric'],
											'customer_image' => ['required', 'file', 'max:1024', 'image'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Data is not valid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$data = array(
						'customer_image' => $request->customer_image,
					);

		$apiMan = new APIManager;
		$res = $apiMan->imageUpdate($data, $gymID, $customerID);
		
		if($res !== 0){
			$msg = array('title' => 'Success', 'message' => 'Your image has been saved', 'image_name' => $res, 'response_code' => 200);
			return json_encode($msg, 200);
		}
		else{
			$error = array('title' => 'Failed', 'message' => 'Something went wrong! Image has not been saved', 'response_code' => 401);
			return json_encode($error, 401);
		}	
	}

	//change customer password
	public function changeCustomerPassword(Request $request){
		$gymID = $request->route('gym_id');
		$customerID = $request->route('customer_id');

		$validator = Validator::make(
										[
											'gym_id' => $gymID,
											'id' => $customerID,
											'old_password' => $request->old_password,
											'new_password' => $request->new_password,
										],

										[
											'gym_id' => ['required', 'numeric'],
											'id' => ['required', 'numeric'],
											'old_password' => ['required', 'string', 'min:4', 'max:50'],
											'new_password' => ['required', 'string', 'min:4', 'max:50'],
										]
									);

		if($validator->fails()){
			$error = array('title' => 'Invalid input', 'message' => 'Data is not valid', 'response_code' => 422);
			return json_encode($error, 422);
		}

		$data = array(
						'old_password' => $request->old_password,
						'new_password' => $request->new_password,
					);

		$apiMan = new APIManager;
		$res = $apiMan->changePassword($data, $gymID, $customerID);
		
		if($res !== 0){
			$msg = array('title' => 'Success', 'message' => 'Password changed', 'response_code' => 200);
			return json_encode($msg, 200);
		}
		else{
			$error = array('title' => 'Failed', 'message' => 'Something went wrong! Password not changed', 'response_code' => 401);
			return json_encode($error, 401);
		}	
	}
}


?>