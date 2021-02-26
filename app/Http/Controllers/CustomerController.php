<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PackageClasses\PackageManager;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\MailHandlerClasses\MailManager;
use App\Models\Customer;
use App\Models\Batch;
use Session;
use App\Http\Controllers\ProfileInformation;

class CustomerController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
        $this->middleware('gymstatus');
	}


	// shows customer adding form
    public function showAddForm(Request $request){
        // print(ProfileInformation::getUser()->id);
    	$packageManager = new PackageManager();
    	$packageNames = $packageManager->getAllPackageNames();

        $bat = Batch::select('batch_name as name')->where(['gym_id' => ProfileInformation::getUser()->id, 'status' => 1, 'is_deleted' => 1])->get();

		return view('customer.add_customer')->with(['packageNames' => $packageNames, 'batches' => $bat]);
    }

	// shows customer lists
    public function showCustomerList(){
        $customerManager = new CustomerManager();
        $customerList = $customerManager->getAllCustomerList();
		return view('customer.customer_list')->with('customers', $customerList);
    }


    //get specific package fee
    public function getPackageFee(Request $request){
    	$data = $request->validate([
    									'pid' => ['required', 'numeric'],
    								]);

    	$packageManager = new PackageManager();
    	return $packageManager->getSpecificPackageFee((int)$data['pid']);
    }


    //adding customer to database
    public function addCustomer(Request $request){
    	$data = $request->validate([
    								'fullname' => ['required', 'regex:/^[\w\s]+$/', 'max:255'],
                                    'father_name' => ['nullable', 'regex:/^[\w\s]+$/', 'max:255'],
    								'phone' => ['required', 'numeric', 'digits:10'],
                                    'another_phone' => ['nullable', 'numeric', 'digits:10'],
    								'email' => ['nullable', 'email', 'string', 'max:150'],
    								'goal' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s]+$/', 'max:255'],
    								'package' => ['required', 'alpha_num', 'string', 'max:255'],
			    					'fee' => ['required', 'numeric'],
			    					'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/]+$/', 'max:255'],
                                    'state' => ['required', 'alpha', 'min:3', 'max:100'],
                                    'city' => ['required', 'alpha', 'min:3', 'max:100'],
                                    'pincode' => ['required', 'numeric', 'digits:6'],
			    					'password' => ['required', 'string', 'min:4', 'max:50'],
                                    'marital_status' => ['nullable', 'numeric'],
                                    'medical_issue' => ['nullable', 'numeric'],
                                    'is_employeed' => ['nullable', 'numeric'],
                                    'place_photo_on_website' => ['nullable', 'numeric'],
                                    'identity_type' => ['nullable', 'string', 'max:100'],
                                    'identity_number' => ['nullable', 'string', 'digits_between:2,100'],
                                    'gender' => ['required', 'alpha', 'max:100'],
                                    'remark' => ['nullable', 'regex:/^[\w\s\,\-]+$/', 'max:255'],
                                    'dob' => ['nullable', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'batch' => ['nullable', 'regex:/^[\w\s\-\:]+$/'],
                                    'height' => ['nullable', 'regex:/^[\w\s\.]+$/'],
                                    'weight' => ['nullable', 'regex:/^[\w\s\.]+$/'],
                                    'eid' => ['nullable', 'regex:/^[\d\-]+$/'],
                                    'customer_image' => ['nullable', 'file', 'max:1024', 'image'],
    							]);

        // checking for phone number duplicacy in single gym
        $ph_check = $this->checkInGymPhoneValidation($data['phone']);
        if($ph_check == 1){
            Session::flash('msg', '<b>Exist!</b> The phone number already exist.');
            return redirect()->back();
        }
        else if($ph_check == -1){
            Session::flash('msg', '<b>Different Gym Member!</b> The person is right now associated with different gym. Please ask them to deactivate their account of previous gym from the mobile application to get register in new gym.');
            
            return redirect()->back();
        }

        //saving data
    	$customerManager = new CustomerManager();
    	$result = $customerManager->store($data);
    	if($result == 1){
            Session::flash('msg', '<b>Success!</b> The member data has been saved.');
            $mail = new MailManager();
            $mail->sendRegistrationMail(
                                        ProfileInformation::getUser()->userGym->gym_name, 
                                        ProfileInformation::getUser()->userGym->gym_email, 
                                        ProfileInformation::getUser()->userGym->gym_phone, 
                                        $data['phone'], 
                                        $data['email'], 
                                        $data['password']
                                    );
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The member data has not been saved.');
        }

    	return redirect()->back();
    }

    private function checkInGymPhoneValidation($phone){
        $inGym = Customer::where(['phone' => $phone, 'gym_id' => ProfileInformation::getUser()->id, 'is_deleted' => 1])->first();
        if(isset($inGym)){
            return 1;
        }

        $otherGym = Customer::where(['phone' => $phone, 'status' => 1, 'is_deleted' => 1])->first();
        if(isset($otherGym)){
            return -1;
        }

        return 0;
    }


    //gets the status of customer from customer details to change it 
    public function setStatus(Request $request){
        $data = $request->validate([
                                    's' => ['required', 'numeric'],
                                    'd' => ['required', 'numeric'], 
                                ]);

        $status = $data['s'];
        $id = $data['d'];
        $customer = new CustomerManager;
        $currentStatus = $customer->changeCustomerStatus($status, $id);

        if($currentStatus == -1){
            return "failed";
        }

        return $currentStatus;
    }

    //delete customer of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];

        $customer = new CustomerManager;
        $res = $customer->deleteCustomer($id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The member has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The member has not been deleted.');
        }
        
        return redirect()->back();
    }

    //show update form of customer of a gym
    public function showUpdateForm(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                ]);

        $id = $data['d'];
        $customer = new CustomerManager;
        $packageManager = new PackageManager();
        $packageNames = $packageManager->getAllPackageNames();

        $res = $customer->getCustomer($id);
        if(empty($res)){
            return redirect()->route('customer_list');
        }

        return view('customer.update_customer')->with(['profile' => $res, 'packageNames' => $packageNames]);
    }

    //update customer data of a gym
    public function updateCustomer(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'],
                                    'fullname' => ['required', 'regex:/^[\w\s]+$/', 'max:255'],
                                    'phone' => ['required', 'numeric', 'digits:10'],
                                    'email' => ['nullable', 'email', 'string', 'max:255'],
                                    'goal' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s]+$/', 'max:255'],
                                    'package' => ['required', 'string', 'max:255', 'regex:/^[\w\s\-\.\,]+$/'],
                                    'fee' => ['required', 'numeric'],
                                    'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/]+$/', 'max:255'],
                                    'gender' => ['required', 'alpha', 'max:100'],
                                    'remark' => ['nullable', 'regex:/^[\w\s\,\-]+$/', 'max:255'],
                                    'dob' => ['nullable', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'customer_image' => ['nullable', 'file', 'max:2048', 'image'],
                                ]);


        $customer = new CustomerManager;
        $res = $customer->update($data);
        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The member has been <i>updated</i>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The member has not been <i>updated</i>.');
        }
        
        return redirect()->back();

    }



}
