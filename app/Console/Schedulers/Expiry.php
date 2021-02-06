<?php 

namespace App\Console\Schedulers;

use Illuminate\Support\Facades\DB;
use App\Notifications\PaymentReminder;
use App\Models\Payment;

/**
 * The expiring class will mark expiring to the customer payment database 

 */
class Expiry
{
	
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


    	DB::table('customer_payment')->where('period_end', '<=', $newDate)
                                            ->where('period_end', '>=', $currentDate)
                                            ->where('status', 1)
                                            ->where('payment_expiry', 0)
                                            ->update(['payment_expiry' => 1]);

        
        DB::table('customer_payment')->where('period_end', '>=', $backDate)
                                            ->where('period_end', '<', $currentDate)
                                            ->where('status', 1)
                                            ->where('payment_expiry', 0)
                                            ->update(['payment_expiry' => 2]);

	}


    //send notification to expiring payment in near days
    public static function paymentExpiring(){
        $pay = new Payment;
        $payments = $pay->select('gym_id', 'customer_id')->where('payment_expiry', 1)->get();
        foreach ($payments as $singlePay) {
            $singlePay->gym->notify(new PaymentReminder($singlePay->customer, 'expiring'));
        }
        
    }

    //send notification to expiring payment in near days
    public static function paymentExpired(){
        $pay = new Payment;
        $payments = $pay->select('gym_id', 'customer_id')->where('payment_expiry', 2)->get();
        foreach ($payments as $singlePay) {
            $singlePay->gym->notify(new PaymentReminder($singlePay->customer, 'expired'));
        }
        
    }


}
?>