<?php 
namespace App\Http\Controllers\AttendanceClasses;

use App\Models\Customer;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\ProfileInformation;

class AttendanceManager{
	private $GYM_ID;

	public function __construct(){
		$temp = ProfileInformation::getUser();
		if(isset($temp)){
			$this->GYM_ID = ProfileInformation::getUser()->id;			
		}
	}

	//store attendance report
	public function storeAttendance(string $phone, $attendance_date){
		$cust = new Customer;
		$custCollection = $cust->select('id')
							   ->where(['gym_id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1, 'phone' => $phone])
							   ->first();

		if(!isset($custCollection)){
			return 'Attendance not found';
		}
		$attendance = new Attendance;

		$attenCheck = $attendance->where(['gym_id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1, 'attendance_date' => $attendance_date, 'customer_id' => $custCollection->id])->first();

		$temp = (array)$attenCheck;
		if(isset($temp) && !empty($temp)){
			return -1;
		}

		$attendance->present = 'yes';
		$attendance->attendance_date = $attendance_date;
		$attendance->customer_id = $custCollection->id;
		$attendance->gym_id = $this->GYM_ID;

		return $attendance->save();
	}

	//get all attendance report of all customers
	public function getAllAttendance(){
		$date = date_create(NULL, timezone_open('Asia/Kolkata'));
        $day = date_format($date, 'Y-m-d H:i:s');
        $timestamp = strtotime($day);
        $currentMonth = date('n', $timestamp);

        $cust_id = Customer::select('id')->where(['gym_id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1])->first();

		// $attendanceCollection = DB::table('customers')
		// 							->join('attendance', 'customers.id', '=', 'attendance.customer_id')
		// 							->select('customers.name', 'customers.phone', 'attendance.present', 'attendance.attendance_date')
		// 							->where(['customers.gym_id' => $this->GYM_ID, 'customers.status' => 1, 'customers.is_deleted' => 1])
		//  							// ->whereRaw('MONTH(attendance.attendance_date) = ?', [$currentMonth])
		//  							->whereIn('customer_id', $ids)
		//  							// ->distinct()
		// 							->get();


        // $cus = new Customer;
        // $attendanceCollection = array();

        // foreach($cust_ids as $element){
        // 	$entry = $cus->where('id' , $element->id)->first()->attendance;
        // 	if(!empty($entry)){
	       //  	array_push($attendanceCollection, $entry);
        // 	}
        // }

        $attendanceCollection = $this->getAttendaceByCustomerId($cust_id->id);

		return $attendanceCollection;
	}

	//get attendance of customer by customer id
	public function getAttendaceByCustomerId(int $id, $month = null){
		$date = date_create(NULL, timezone_open('Asia/Kolkata'));
        $day = date_format($date, 'Y-m-d H:i:s');
        $timestamp = strtotime($day);

        if(isset($month)){
        	$currentMonth = $month;
        }
        else{
        	$currentMonth = date('n', $timestamp);
        }

		$cus = new Customer;
		$atten = $cus->where(['id' => $id, 'gym_id' => $this->GYM_ID])
		    		 ->first()
					 ->attendance()
					 ->whereRaw('MONTH(attendance.attendance_date) = ?', [$currentMonth])
					 ->get();

		return $atten;
	}

	//get all customers 
	public function getCustomers(){
		$customerManager = new CustomerManager;
		$result = $customerManager->getAllCustomerData('id');
		return $result;
	}



	//give all customer name and number
	public function customerNameAndNumber(string $value){
		$customerManager = new CustomerManager;
		$result = $customerManager->getAllCustomerNameAndPhone($value);
		return $result;
	}

	//give attendance details of all customers by month
 	public function getAttendanceDetailByMonth(int $id, int $monthNumber){
 		$attendanceCollection = $this->getAttendaceByCustomerId($id, $monthNumber);
 		return $attendanceCollection;

 	}


 	//give today's attendance report
 	public function getTodayAttendanceReport(){
 		// $cus = new Customer;
 		// $res = $cus->where(['customers.status' => 1, 'customers.is_deleted' => 1, 'customers.gym_id' => $this->GYM_ID])
 		// 			  ->whereRaw('attendance_date = CURRENT_DATE()')
 		// 			  ->get();

 		$result =DB::table('attendance') 
 							->join('customers', 'attendance.customer_id', '=', 'customers.id')
							->select('attendance.attendance_date', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customers.gym_id' => $this->GYM_ID, 'customers.status' => 1, 'customers.is_deleted' => 1])
	 					    ->whereRaw('attendance.attendance_date = CURRENT_DATE()')
							->orderBy('attendance.attendance_date')
 							->get();

 		return $result;
 	}


 	//give attendance on a given date
 	public function getAttendanceByDate($date){
 		date_default_timezone_set('Asia/Kolkata');
 		$new_date = date_create($date);
 		$d_formatted = date_format($new_date, 'Y-m-d');

 		$result =DB::table('attendance') 
 							->join('customers', 'attendance.customer_id', '=', 'customers.id')
							->select('attendance.attendance_date', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customers.gym_id' => $this->GYM_ID, 'customers.status' => 1, 'customers.is_deleted' => 1])
	 					    ->whereRaw('attendance.attendance_date = ?', [$d_formatted])
							->orderBy('attendance.attendance_date')
 							->get();


 		return $result;
 	}

 	/*
	=================================================
		
		API CODING BEGINS 
	
	=================================================
 	*/

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

 	/*
	=================================================
		
		API CODING ENDS 
	
	=================================================
 	*/

}


?>