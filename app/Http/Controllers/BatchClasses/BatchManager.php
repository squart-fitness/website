<?php 
namespace App\Http\Controllers\BatchClasses;

//custom imports
use App\Models\Batch;
use App\Models\Customer;
use App\Http\Controllers\CommonClasses\HelperManager;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\ProfileInformation;

class BatchManager{

	use HelperManager;

    private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	//get all customer name and phone from customer manager
    public function getNamePhone(){
    	$cm = new CustomerManager;
    	$result = $cm->getCustomerNamePhone();
    	return $result;
    }

    //get all batches in a gym
    public function getAllBatches(){
    	$bat = new Batch;
    	$res = $bat->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])->get();
    	return $res;
    }

    //get current batch of a customer
    public function getCurrentBatch($data){
    	$cust = Customer::select('batch')->where(['gym_id' => $this->GYM_ID, 'id' => $data['id'], 'is_deleted' => 1])->first();
    	return $cust;
    }

    //update batch of customer
    public function updateBatch($data){
    	$cust = Customer::where(['gym_id' => $this->GYM_ID, 'id' => $data['member_id'], 'is_deleted' => 1])->first();
    	$cust->batch = $data['batch'];
    	$res = $cust->save();
    	return $res;
    }
}