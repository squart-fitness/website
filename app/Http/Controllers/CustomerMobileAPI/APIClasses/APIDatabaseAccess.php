<?php 
namespace App\Http\Controllers\CustomerMobileAPI\APIClasses;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\AssignedDiet;
use App\Models\DietPlan;
use App\Models\AssignedWorkout;
use App\Models\Workout;
use App\Models\Batch;
use App\Models\Package;
use App\Models\GymFeedback;
use Image;


class APIDatabaseAccess{

	//get gym information by gym owner or user id
 	public function getGym($id){
 		$user = User::find($id);
 		$gym = $user->userGym;
 		$gym->username = $user->username;

 		return $gym;
 	}

 	//API get full attendance report of a single member 
 	public function getFullAttedanceReportById($id){
 		$atten = new Attendance;
 		$report = $atten->where('customer_id', $id)->get();
 		return $report;
 	}


 	// API set attendance of a member
 	public function setAttendanceFromAPI($date, $gymUsername, $customerID){
 		$gym = User::select('id')->where('username', $gymUsername)->first();

 		$atten = new Attendance;
 		$attenCheck = $atten->where(['gym_id' => $gym->id, 'status' => 1, 'is_deleted' => 1, 'attendance_date' => $date, 'customer_id' => $customerID])->first();

		$temp = (array)$attenCheck;
		if(isset($temp) && !empty($temp)){
			return -1;
		}


 		$atten->present = 'yes';
		$atten->attendance_date = $date;
		$atten->customer_id = $customerID;
		$atten->gym_id = $gym->id;

		return $atten->save();
 	}


 	//get single member payment detail
 	public function getSingleCustomerPayment($id){
 		$pay = Payment::where('customer_id', $id)->latest()->get();
		return $pay;
 	}


 	//update customer information from api or mobile application
    public function apiUpdateCustomerInfo($data){
        $cust = Customer::where(['id' => $data['customer_id'], 'gym_id' => $data['gym_id'], 'is_deleted' => 1])->first();
        $cust->phone = $data['phone'];
        $cust->email = $data['email'];
        $cust->goal = $data['goal'];
        $cust->address = $data['address'];
        $cust->dob = $data['dob'];
        $cust->gender = $data['gender'];
        $cust->height = $data['height'];
        $cust->weight = $data['weight'];

        $res = $cust->save();

        return $res;
    }


    //get member diet plan
    public function memberAllDiet($gym_id, $id){
        $diets_id = AssignedDiet::select('dietplan_id')
                                ->where(['gym_id' => $gym_id, 'customer_id' => $id, 'is_deleted' => 1])
                                ->get();

        $id = array();
        foreach($diets_id as $value){
            array_push($id, $value->dietplan_id);
        }

        $diet_list = DietPlan::where(['gym_id' => $gym_id, 'is_deleted' => 1])
                               ->whereIn('id', $id)
                               ->get();
        return $diet_list;
    }


    //get member workout plan
    public function memberAllWorkout($gym_id, $id){
        $workout_planID = AssignedWorkout::select('workout_plan_id')
                                ->where(['gym_id' => $gym_id, 'customer_id' => $id, 'is_deleted' => 1])
                                ->get();

        $id = array();
        foreach($workout_planID as $value){
            array_push($id, $value->workout_plan_id);
        }

        $workout_list = Workout::where(['gym_id' => $gym_id, 'is_deleted' => 1])
                                ->whereIn('id', $id)
                                ->get();
        return $workout_list;
    }


    //save social links to database
    public function saveSocialLinks($data, $gym_id, $customer_id){
        $cust = Customer::where(['id' => $customer_id, 'gym_id' => $gym_id, 'status' => 1, 'is_deleted' => 1])->first();
        $cust->facebook = $data['facebook'];
        $cust->instagram = $data['instagram'];
        $cust->twitter = $data['twitter'];

        $res = $cust->update();
        return $res;
    }


    //update customer image from mobile app
    public function updateCustomerImage($data, $gym_id, $customer_id){
    	$cust = Customer::where(['id' => $customer_id, 'gym_id' => $gym_id, 'status' => 1, 'is_deleted' => 1])->first();
    	$cust->customer_image = $this->imageModification($data['customer_image']); 
    	$res = $cust->update();

    	return $res;
    }


    //get notification of payment reminder to customer
    public function getNotification($gym_id, $customer_id){
        $cust = Customer::select('name', 'phone', 'package_end_date')
                            ->where(['gym_id' => $gym_id, 'id' => $customer_id, 'status' => 1])
                            ->where(function($query){
                                $query->where('payment_expiry', '=', 1)
                                      ->orWhere('payment_expiry', '=', 2);
                            })->get();

        return $cust;
    }

    //get all batches
    public function getBatches($gym_id){
        $bat = Batch::where(['gym_id' => $gym_id, 'status' => 1])->get();
        return $bat;
    }

    //get all packages
    public function getPackages($gym_id){
        $package = Package::where(['gym_id' => $gym_id, 'status' => 1])->get();
        return $package;
    }

    //get customer rating
    public function getCustomerRating($gym_id, $customer_id){
        $cust = Customer::select('rating_count')->where(['gym_id' => $gym_id, 'id' => $customer_id, 'status' => 1])->first();
        return $cust;
    }

    //set gym rating by customers
    public function setGymRating($data, $gym_id, $customer_id){
        $gymFeed = new GymFeedback();

        $anyFeedback = $gymFeed->where(['gym_id' => $gym_id, 'customer_id' => $customer_id, 'is_deleted' => 1])->first();
        if(isset($anyFeedback)){
            $res =$gymFeed->where(['gym_id' => $gym_id, 'customer_id' => $customer_id, 'is_deleted' => 1])
                          ->update(['rating_count' => $data['rating'], 'description' => $data['feedback']]);

            return $res;
        }

        $gymFeed->gym_id = $gym_id;
        $gymFeed->customer_id = $customer_id;
        $gymFeed->rating_count = $data['rating'];
        $gymFeed->description = $data['feedback'];

        return $gymFeed->save();
    }


    //get freezing history
    public function getFreezingHistory($gym_id, $customer_id){
        $cust = Customer::select('freezing_history')->where(['gym_id' => $gym_id, 'id' => $customer_id, 'status' => 1])->first();
        return $cust;
    }

    //image modification and save to destination location
    private function imageModification($image){
        if(!isset($image)){
            return null;
        }

        $fileName = 'c_' . uniqid() . time() . '.' . strtolower($image->getClientOriginalExtension());
        $location = storage_path('app/public/c_images/'.$fileName);
        $img = Image::make($image);

        if($img->width() < $img->height() && $img->height() >= 300){
            $img->resize(300, 400);
        }
        else{
            $img->width() >= 400 || $img->height() >= 300 ? $img->resize(400, 300) : '';
        }

        $img->save($location);

        return $fileName;
    }
}