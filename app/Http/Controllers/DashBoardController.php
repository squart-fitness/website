<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Console\Schedulers\Expiry;
use App\Models\Payment;
use App\Models\Customer;
use App\Notifications\PaymentReminder;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\EnquiryClasses\EnquiryManager;
use App\Http\Controllers\AttendanceClasses\AttendanceManager;
use App\Http\Controllers\Employee\EmployeeClasses\EmployeeManager;
use View;

use App\Http\Controllers\ProfileInformation;

class DashBoardController extends Controller
{	
    public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
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
        $cust = new Customer();
        $customerPaymentExpiryList = $cust->select('gym_id', 'name', 'phone', 'package_end_date')->where('payment_expiry', 1)->get();
        foreach ($customerPaymentExpiryList as $element) {
            $element->gym->notify(new PaymentReminder($element, 'expiring'));
        } 
    }
}
