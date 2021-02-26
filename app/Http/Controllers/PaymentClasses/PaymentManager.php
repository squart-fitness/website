<?php 
namespace App\Http\Controllers\PaymentClasses;

use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\ProfileInformation;


class PaymentManager{

	private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	//give single customer name and number with due amount
	public function getCustomerNameAndNumber($memberID){
		$cust = new Customer;
		$temp = $cust->where(['username' => $memberID, 'gym_id' => $this->GYM_ID, 'is_deleted' => 1])->first()->payment->first();
		if(!isset($temp)){
			$username = $cust->select('id', 'name', 'phone', 'fee')->where(['username' => $memberID, 'gym_id' => $this->GYM_ID, 'is_deleted' => 1])->first();
			return $username;
		}

		$custEloquent = DB::table('customer_payment')
							->join('customers', 'customer_payment.customer_id', '=', 'customers.id')
							->select('customer_payment.due_amount', 'customer_payment.period_end', 'customers.id', 'customers.name', 'customers.phone', 'customers.fee')
							->where(['customers.gym_id' => $this->GYM_ID, 'customers.username' => $memberID, 'customers.is_deleted' => 1])
							->orderByDesc('customer_payment.created_at')
							->limit(1)
							->get();

		return ($custEloquent);
	}

	//store customer payment data
	public function addPaymentOfCustomer($data){
		$total = $data['total_amt'] - $data['discount'];
		$due = $total - $data['paid_amt'];

		$pay = new Payment();
		$pay->gym_id = $this->GYM_ID;
		$pay->customer_id = $data['customer_id'];
		$pay->purpose = $data['purpose'];
		$pay->payment_mode = $data['pay_mode'];
		$pay->total_amount = $total;
		$pay->paid_amount = $data['paid_amt'];
		$pay->due_amount = $due;
		$pay->period_start = $data['per_start'];
		$pay->period_end = $data['per_end'];
		$pay->discount = $data['discount'];

		if(isset($data['due_date']))
            $pay->due_date = $data['due_date'];

		$result = $pay->save();
		if($result == 1)
			Customer::where(['gym_id' => $this->GYM_ID, 'id' => $data['customer_id']])->update(['package_end_date' => $data['per_end']]);

		return $result;

 	}

 	//give payment details of all active customers of a  gym
 	public function getPaymentDetailOfAll(){
 		$pay = new Payment;
 		$payEloquent = DB::table('customer_payment')
							->join('customers', 'customer_payment.customer_id', '=', 'customers.id')
							->select('customer_payment.*', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customers.gym_id' => $this->GYM_ID, 'customer_payment.status' => 1, 'customers.is_deleted' => 1])
							->orderByDesc('customer_payment.created_at')
							->get();

 		return $payEloquent;
 	}

 	//give payment details of all customers by month
 	public function getPaymentDetailByMonth(int $monthNumber){
 		$pay = new Payment;
 		$paymentCollection =DB::table('customer_payment') 
 							->join('customers', 'customer_payment.customer_id', '=', 'customers.id')
							->select('customer_payment.*', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customer_payment.gym_id' => $this->GYM_ID, 'customer_payment.status' => 1, 'customer_payment.is_deleted' => 1])
 							->whereRaw('MONTH(customer_payment.created_at) = ?', [$monthNumber])
							->orderByDesc('customer_payment.created_at')
 							->get();
 		return $paymentCollection;

 	}

 	//give payment details of all customers by initial and final date
 	public function getPaymentByDate($initial, $final){
 		$pay = new Payment;
 		$paymentCollection = DB::table('customer_payment') 
 							->join('customers', 'customer_payment.customer_id', '=', 'customers.id')
							->select('customer_payment.*', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customer_payment.gym_id' => $this->GYM_ID, 'customer_payment.status' => 1, 'customer_payment.is_deleted' => 1])
 							->whereRaw('customer_payment.created_at > ? AND customer_payment.created_at < ?', [$initial, $final])
							->orderByDesc('customer_payment.created_at')
 							->get();

 		return $paymentCollection;
 	}

    //give customer payment details by their no of days near to expire
 	public function getPaymentsByExpiringDays($days){
 		$date = date_create(NULL, timezone_open('Asia/Kolkata'));
        $day = date_format($date, 'Y-m-d H:i:s');
        $timestamp = strtotime($day);
        $incrementedDays = strtotime('+'.$days.'days', $timestamp);
        $new_date = date('Y-m-d H:s:i', $incrementedDays);
        $current_date = date('Y-m-d H:s:i');

        // return $new_date;
        $paymentCollection = DB::table('customer_payment') 
 							->join('customers', 'customer_payment.customer_id', '=', 'customers.id')
							->select('customer_payment.*', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customer_payment.gym_id' => $this->GYM_ID, 'customer_payment.status' => 1, 'customer_payment.is_deleted' => 1])
 							->whereRaw('customer_payment.period_end > ? AND customer_payment.period_end < ?', [$current_date, $new_date])
							->orderByDesc('customer_payment.created_at')
 							->get();

 		return $paymentCollection;
 	}

 	//give pending payment details of all customers 
 	public function getPendingPaymentDetail(){
 		$pay = new Payment;
 		$paymentCollection =DB::table('customer_payment') 
 							->join('customers', 'customer_payment.customer_id', '=', 'customers.id')
							->select('customer_payment.*', 'customers.name', 'customers.phone', 'customers.username')
							->where(['customer_payment.gym_id' => $this->GYM_ID, 'customer_payment.status' => 1, 'customer_payment.is_deleted' => 1])
 							->whereRaw('customer_payment.period_end < CURRENT_DATE()')
							->orderByDesc('customer_payment.created_at')
 							->get();
 		return $paymentCollection;

 	}


 	//get usernames lists
 	public function getUsernames(string $value){
 		$customerManager = new CustomerManager;
 		$result = $customerManager->getAllCustomerUsername($value);
 		return $result;
 	}

 	//get single member payment detail
 	public function getSingleCustomerPayment($id){
 		$pay = Payment::where('customer_id', $id)->latest()->get();
		return $pay;
 	}
}

?>