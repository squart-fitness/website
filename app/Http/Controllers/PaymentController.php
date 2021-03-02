<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PaymentClasses\PaymentManager;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\User;
use Session;


class PaymentController extends Controller
{

    public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
    }

    
    //shows customer payment form
    public function showCustomerPaymentForm(){
		return view('customer.payment');
    }

    //show customers payment details
    public function showCustomerPaymentDetail(){
    	$paymentManager = new PaymentManager();
    	$payDetail = $paymentManager->getPaymentDetailOfAll();
    	$payPending = $paymentManager->getPendingPaymentDetail();
		return view('customer.payment_details')->with(['payments' => $payDetail, 'pendingPayments' => $payPending]);
    }

    //show customer name and number to take payment
    public function showCustomerNameAndNumber(Request $request){
    	$data = $request->validate([
    								'username' => ['required', 'alpha_num', 'string'],
    							]);
    	$paymentManager = new PaymentManager();
    	$customerData = $paymentManager->getCustomerNameAndNumber($data['username']);
    	return $customerData;
    }

    //show customer payment details in months
    public function showCustomerPaymentInMonth(Request $request){
    	$data = $request->validate([
    								'month' => ['required', 'numeric', 'regex:/^[0-9]{1,2}$/', 'max:12'],
    							]);

    	$paymentManager = new PaymentManager();
    	$paymentDetail = $paymentManager->getPaymentDetailByMonth((int)$data['month']);

    	return $paymentDetail;
    }

    //show customer payment details from initial date to final date
    public function showPaymentByDate(Request $request){
        $data = $request->validate([
                                    'initial' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'final' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                ]);

        $paymentManager = new PaymentManager;
        $payments = $paymentManager->getPaymentByDate($data['initial'], $data['final']);
        return $payments;
    }

    //show customer payment details by their no of days near to expire
    public function showPaymentByExpiringDays(Request $request){
        $data = $request->validate([
                                    'expiring_days' => ['required', 'numeric', 'min:1'],
                                ]);

        $paymentManager = new PaymentManager;
        $payments = $paymentManager->getPaymentsByExpiringDays($data['expiring_days']);
        return $payments;
    }

    //show Usernames
    public function showUsernames(Request $request){
        $data = $request->validate([
                                    'value' => ['required', 'alpha_num', 'string'],
                                ]);

    	$paymentManager = new PaymentManager();
    	return $paymentManager->getUsernames($data['value']);
    }

    //save payment of customer to database
    public function savePayment(Request $request){
        // dd(($request->per_start));

    	$data = $request->validate([
    								'customer_id' => ['required', 'numeric'],
    								'purpose' => ['required',  'regex:/^[a-zA-Z\s]+$/'],
    								'pay_mode' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
    								'total_amt' => ['required', 'regex:/^[0-9]+$/'],
    								'paid_amt' => ['required', 'regex:/^[0-9]+$/'],
    								'per_start' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
    								'per_end' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'due_date' => ['nullable', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'discount' => ['required', 'numeric'],
    							]);


    	$paymentManager = new PaymentManager();
    	$result = $paymentManager->addPaymentOfCustomer($data);
    	if($result == 1){
            Session::flash('msg', '<b>Success!</b> Customer Payment has been saved.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> Customer Payment has not been saved.');
        }
    	return redirect()->back();
    }

    public function research(){
    	$paymentManager = new PaymentManager();
    	return $paymentManager->getPendingPaymentDetail();
    }

}
