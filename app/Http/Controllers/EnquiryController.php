<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnquiryClasses\EnquiryManager;
use App\Http\Controllers\PackageClasses\PackageManager;
use App\Models\Batch;
use App\Models\Customer;
use App\Models\Enquiry;

use Illuminate\Http\Request;
use Session;
use Validator;

class EnquiryController extends Controller
{
    public function __construct(){
        $this->middleware('gymstatus');
        $this->middleware('auth');
    }

	//show enquriy form
    public function showEnquiryForm(){
        $pack = new PackageManager;
        $packages = $pack->getAllPackageNames();
		return view('enquiry.add_enquiry')->with('packages', $packages);
    }

    //save enquiry
    public function saveEnquiry(Request $request){
    	$data = $request->validate([
    								'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
    								'phone' => ['required', 'numeric', 'digits:10'],
                                    'address' => ['nullable', 'regex:/^$|^[\w\s\,\-\.\:\/]+$/'],
                                    'goal' => ['required', 'regex:/^[\w\s]+$/'],
                                    'plan_interested' => ['nullable', 'regex:/^$|^[\w\s\,\-\.\:\/]+$/'],
                                    'follow_up_date' => ['nullable', 'regex:/^$|^\d{4}\-\d{2}\-\d{2}$/'],
                                    'trail_date' => ['nullable', 'regex:/^$|^\d{4}\-\d{2}\-\d{2}$/'],
                                    'response' => ['nullable', 'regex:/^$|^[\w\s]+$/'],
                                    'remarks' => ['nullable', 'regex:/^$|^[\w\s]+$/'],
                                    'query' => ['nullable', 'regex:/^$|^[\w\s]+$/'],
                                    'gender' => ['required', 'alpha'],
                                    'soe' => ['required', 'regex:/^$|^[\w\s\,\-\.\:\/]+$/'],
                                    'height' => ['nullable', 'regex:/^[\w\s\.]+$/'],
                                    'weight' => ['nullable', 'regex:/^[\w\s\.]+$/'],
    							]);

        // checking for phone number duplicacy in single gym
        $ph_check = $this->checkInGymPhoneValidation($data['phone']);
        if($ph_check == 1){
            Session::flash('is_save', '<b>Exist!</b> The phone number already exist.');
            return redirect()->back();
        }

        //saving data 
        $enquiry = new EnquiryManager;
    	$result = $enquiry->storeSingleEnquiry($data);
    	if($result == 1){
    		Session::flash('is_save', '<b>Success!</b> The enquiry has been saved.');
    	}
    	else{
    		Session::flash('is_save', '<b>Failed!</b> The enquiry has not been saved.');
    	}

    	return redirect()->back();
    }

    private function checkInGymPhoneValidation($phone){
        $inGym = Enquiry::where(['customer_phone' => $phone, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
        if(isset($inGym)){
            return 1;
        }

        return 0;
    }

    //shows all enquiries of a single gym
    public function showEnquiries(){
    	$enquiry = new EnquiryManager;
    	$res = $enquiry->getEnquiry();
    	return view('enquiry.enquiry_detail')->with('enquiries', $res);
    }

    //show enquiries in month of single gym
    public function showEnquiryInMonth(Request $request){
    	$data = $request->validate([
                                    'start_date' => ['regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'end_date' => ['regex:/^\d{4}\-\d{2}\-\d{2}$/'],
    							]);

    	$enquiry = new EnquiryManager;
    	$enquiryDetail = $enquiry->getEnquiryDetailByMonth($data['start_date'], $data['end_date']);

    	return $enquiryDetail;
    }


    //show enquiries in according to filteration
    public function filterEnquiry(Request $request){
        $data = $request->validate([
                                    'by' => ['required', 'alpha'],
                                    'value' => ['required', 'regex:/^[\w\s\,\-\.\:\/]+$/'],
                                ]);

        $enquiry = new EnquiryManager;
        $filteredEnquiry = $enquiry->getFilteredEnquiry($data['by'], $data['value']);

        return $filteredEnquiry;
    }

    //show enquiry update form
    public function showUpdateForm(Request $request){
        $data = $request->validate(['d' => ['required', 'numeric']]);

        $em = new EnquiryManager;
        $enq = $em->getSingleEnquiry((int)$data['d']);

        if(empty($enq)){
            return redirect()->route('showall_enquiry');
        }

        $pack = new PackageManager;
        $packages = $pack->getAllPackageNames();
        return view('enquiry.enquiry_update')->with(['enquiry' => $enq, 'packages' => $packages]);
    }


    //update enquiry
    public function updateEnquiry(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'],
                                    'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                                    'phone' => ['required', 'numeric', 'digits:10'],
                                    'address' => ['nullable', 'regex:/^$|^[\w\s\,\-\.\:\/]+$/'],
                                    'goal' => ['required', 'regex:/^[\w\s]+$/'],
                                    'plan_interested' => ['nullable', 'regex:/^$|^[\w\s\,\-\.\:\/]+$/'],
                                    'follow_up_date' => ['nullable', 'regex:/^$|^\d{4}\-\d{2}\-\d{2}$/'],
                                    'trail_date' => ['nullable', 'regex:/^$|^\d{4}\-\d{2}\-\d{2}$/'],
                                    'response' => ['nullable', 'regex:/^$|^[\w\s]+$/'],
                                    'remarks' => ['nullable', 'regex:/^$|^[\w\s]+$/'],
                                    'query' => ['nullable', 'regex:/^$|^[\w\s]+$/'],
                                    'gender' => ['required', 'alpha'],
                                    'soe' => ['required', 'regex:/^$|^[\w\s\,\-\.\:\/]+$/'],
                                    'height' => ['nullable', 'regex:/^[\w\s\.]+$/'],
                                    'weight' => ['nullable', 'regex:/^[\w\s\.]+$/'],
                                ]);

        // checking for phone number duplicacy in single gym
        $ph_check = $this->checkInGymPhoneValidation($data['phone']);
        if($ph_check == 1){
            Session::flash('is_save', '<b>Exist!</b> The phone number already exist.');
            return redirect()->back();
        }

        $enquiry = new EnquiryManager;
        $result = $enquiry->updateEnq($data);
        
        if($result == 1){
            Session::flash('is_save', '<b>Success!</b> The enquiry has been updated.');
        }
        else{
            Session::flash('is_save', '<b>Failed!</b> The enquiry has not been updated.');
        }

        return redirect()->back();
    }


    //move enquiry to add memeber
    public function moveEnquiry(Request $request){
        $data = $request->validate([
                                    'eid' => ['required', 'regex:/^[\d\-]+$/']
                                ]);

        $enquiry = new EnquiryManager;
        $result = $enquiry->getEnquiryByUniqueId($data['eid']);
        if(empty($result)){
            return redirect()->route('showall_enquiry');
        }

        $cust = Customer::select('id')->where(['gym_id' => auth()->user()->id, 'phone' => $result->customer_phone])->first();
        if(!empty($cust->id)){
            Session::flash('msg', '<b>Failed!</b> The member is already exist or repeated phone number.');
            return redirect()->back();
        }

        $packageManager = new PackageManager();
        $packageNames = $packageManager->getAllPackageNames();

        $bat = Batch::select('batch_name as name')->where(['gym_id' => auth()->user()->id, 'status' => 1, 'is_deleted' => 1])->get();

        return view('customer.add_customer')->with(['packageNames' => $packageNames, 'batches' => $bat, 'profile' => $result]);
    }

    //show enquiry profile
    public function enquiryProfile($eid){
        $validator = Validator::make(['eid' => $eid], ['eid' => ['required', 'regex:/^[\d\-]+$/']]);

        if($validator->fails()){
            return redirect()->back();
        }

        $eqm = new EnquiryManager;
        $enq = $eqm->getEnquiryProfile($eid);
        
        if(empty($enq)){
            return redirect()->route('showall_enquiry');
        }

        return view('enquiry.enquiry_profile')->with('enquiry', $enq);
    }


    //gets the status of enquiry from enquiry details to change it 
    public function setStatus(Request $request){
        $data = $request->validate([
                                    's' => ['required', 'numeric'],
                                    'd' => ['required', 'numeric'], 
                                ]);

        $status = $data['s'];
        $id = $data['d'];
        $enquiry = new EnquiryManager;
        $currentStatus = $enquiry->changeEnquiryStatus($status, $id);

        if($currentStatus == -1){
            return "failed";
        }

        return $currentStatus;
    }

    //delete enquiry of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];

        $enquiry = new EnquiryManager;
        $res = $enquiry->deleteEnquiry($id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The enquiry has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The enquiry has not been deleted.');
        }
        
        return redirect()->back();
    }
}
