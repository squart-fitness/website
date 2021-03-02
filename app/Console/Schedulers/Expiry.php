<?php 

namespace App\Console\Schedulers;

use Illuminate\Support\Facades\DB;
use App\Notifications\PaymentReminder;
use App\Models\Payment;
use App\Models\Customer;

/**
 * The expiring class will mark expiring to the customer payment database 

 */
class Expiry
{
	private $paymentExpiring = 1;
    private $paymentExpired = 2;
	function __construct()
	{
		$date = date_create(NULL, timezone_open('Asia/Kolkata'));
        $day = date_format($date, 'Y-m-d H:i:s');
        $timestamp = strtotime($day);
        $incrementDays = strtotime("+5 days", $timestamp);
        $newDate = date('Y-m-d H:s:i', $incrementDays);

        $decrementDays = strtotime("-5 days", $timestamp);
        $backDate = date('Y-m-d H:s:i', $decrementDays);
        
        $currentDate = date('Y-m-d H:s:i', $timestamp);

        DB::statement("
                        UPDATE customers 
                        SET payment_expiry = 
                        CASE 
                        WHEN package_end_date <= ? AND package_end_date >= ? THEN 1
                        WHEN package_end_date < ? THEN 2
                        WHEN package_end_date > ? THEN 3
                        ELSE 10
                        END
                        WHERE is_deleted = 1
                        ", [$newDate, $currentDate, $backDate, $currentDate, $currentDate]);

	}


    //send notification to expiring payment in near days
    public static function paymentExpiring(){
        $cust = new Customer();
        $customerPaymentExpiryList = $cust->select('gym_id', 'name', 'phone', 'package_end_date')->where('payment_expiry', $this->paymentExpiring)->get();
        foreach ($customerPaymentExpiryList as $element) {
            $element->gym->notify(new PaymentReminder($element, 'expiring'));
        }   
    }

    //send notification to expiring payment in near days
    public static function paymentExpired(){
        $cust = new Customer();
        $customerPaymentExpiryList = $cust->select('gym_id', 'name', 'phone', 'package_end_date')->where('payment_expiry', $this->paymentExpired)->get();
        foreach ($customerPaymentExpiryList as $element) {
            $element->gym->notify(new PaymentReminder($element, 'expired'));
        }   
    }


}
?>