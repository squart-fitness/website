<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Console\Schedulers\Expiry;
use App\Models\Payment;
use App\Notifications\PaymentReminder;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\EnquiryClasses\EnquiryManager;
use App\Http\Controllers\AttendanceClasses\AttendanceManager;
use App\Http\Controllers\Employee\EmployeeClasses\EmployeeManager;
use View;

class DashBoardController extends Controller
{	
    public function __construct(){
        $this->middleware(['gymstatus', 'auth']);
    }

    
    public function index(){
        $cust = new CustomerManager();
        $emp = new EmployeeManager();
        $enq = new EnquiryManager();

        $activeCustomerCount = $cust->getActiveCustomerCount();
        $employeeCount = $emp->getTotalEmployeeCount();
        $enquiryCount = $enq->getEnquiryCount();

        $counts = array();
        $counts['customer_active'] = $activeCustomerCount;
        $counts['employee_count'] = $employeeCount;
        $counts['enquiry_count'] = $enquiryCount;
    	return view('dashboard.index')->with('counts', $counts);
    }

    //shows today's attendance report
    public function showTodayAttendanceReport(){
        $atten = new AttendanceManager;
        $result = $atten->getTodayAttendanceReport();
        return $result;
    }

    //shows list of all employees
    public function showActiveEmployees(){
        $emp = new EmployeeManager;
        $result = $emp->getActiveEmployees();
        return $result;
    }

















    public function research(){

        // $date = date_create(NULL, timezone_open('Asia/Kolkata'));
        // $day = date_format($date, 'Y-m-d H:i:s');
        // $timestamp = strtotime($day);
        // $incrementDays = strtotime("+5 days", $timestamp);
        // $currentDate = date('Y-m-d H:s:i', $timestamp);
     //    $newDate = date('Y-m-d H:s:i', $incrementDays);

    	// $result = DB::table('customer_payment')->where('period_end', '<=', $newDate)
     //                                        ->where('period_end', '>', $currentDate)
     //                                        ->where('status', 1)
     //                                        ->update(['payment_expiry' => 1]);

     //    foreach ($result as $value) {
     //        print_r($value);
     //    }


        // $pay = new Payment;

        // $date = date_create(NULL, timezone_open('Asia/Kolkata'));
        // $day = date_format($date, 'Y-m-d H:i:s');
        // $timestamp = strtotime($day);
        // $currentDate = date('Y-m-d', $timestamp);

        // print_r($currentDate);

        $pay = new Payment;
        $payments = $pay->select('gym_id', 'customer_id')->where('payment_expiry', 1)->get();
        foreach ($payments as $singlePay) {
            print($singlePay->customer);
            print($singlePay->gym->notify(new PaymentReminder($singlePay->customer)));
            echo "<br><br><br>";
        }


        return;
    }
}
