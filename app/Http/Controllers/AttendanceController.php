<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AttendanceClasses\AttendanceManager;
use Illuminate\Http\Request;
use Session;

class AttendanceController extends Controller
{

    public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
    }

    
    // shows customer attendance form 
    public function showAttendanceForm(){
    	$attendanceManager = new AttendanceManager;
    	// $attendanceResult = $attendanceManager->getAllAttendance();
        $customerList = $attendanceManager->getCustomers();
		return view('customer.attendance')->with(['customers' => $customerList]);
    }

    // show single customer attendance
    // public function showSingleCustomerAttendance(Request $request){
    //     $data = $request->validate([
    //                                 'id' => 'required|numeric',
    //                                 // 'month' => 'numeric'
    //                             ]);

    //     $attendanceManager = new AttendanceManager;
    //     $result = $attendanceManager->getAttendaceByCustomerId($data['id']);
    //     return $result;
    // }

    //set attendance of customer
    public function setAttendance(Request $request){
    	$data = $request->validate([
    								'phone' => ['required', 'string', 'digits:10'],
                                    'attendance_date' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
    							]);

    	$attendanceManager = new AttendanceManager;
    	$res = $attendanceManager->storeAttendance($data['phone'], $data['attendance_date']);
        if($res == 1){
            Session::flash('msg', '<b>Success!</b> Attendance has been saved.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Failed!</b> Already created for this day.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> Attendance has not been saved.');
        }

    	return redirect()->back();
    }

    //show names and phone number of customer
    public function showNames(Request $request){
        $data = $request->validate(['name' => 'regex:/^[\w\s]+$/', 'max:255']);
    	$attendanceManager = new AttendanceManager;
    	$result = $attendanceManager->customerNameAndNumber($data['name']);
    	return $result;
    }

    //show customer payment details in months
    // public function showCustomerAttendanceInMonth(Request $request){
    // 	$data = $request->validate([
    // 								'month' => ['required', 'numeric', 'regex:/^[0-9]{1,2}$/', 'max:12'],
    //                                 'id' => ['required', 'numeric'],
    // 							]);

    // 	$attendanceManager = new AttendanceManager();
    // 	$attendanceDetail = $attendanceManager->getAttendanceDetailByMonth((int)$data['id'], (int)$data['month']);

    // 	return $attendanceDetail;
    // }

    //attendance accouding to date
    public function showAttendanceByDate(Request $request){
        $data = $request->validate([
                                    'date' => ['required'],
                                ]);

        $atm = new AttendanceManager;
        $attendance = $atm->getAttendanceByDate($data['date']);

        return $attendance;
    }
}
