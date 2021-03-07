<?php 

namespace App\Http\Controllers\PackageClasses;
use App\Models\Package;
use App\Models\Customer;
use App\Http\Controllers\ProfileInformation;
use App\Http\Controllers\CustomerClasses\CustomerManager;

class PackageManager{
	
	private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	//gives list of all packages
	public function getAllPackageList(){
		$pack = new Package();
		$eloquentObj = $pack->where(['gym_id' => $this->GYM_ID, 'is_deleted' => '1'])->get();
		return $eloquentObj;
	}

	//gives list of all packages names only
	public function getAllPackageNames(){
		$pack = new Package();
		$eloquentObj = $pack->select('package_name', 'id')->where(['gym_id' => $this->GYM_ID, 'is_deleted' => '1'])->get();
		return $eloquentObj;
	}	

	//gives specific package fee
	public function getSpecificPackageFee($pid){
		$pack = new Package();
		$eloquentObj = $pack->select('fee')->where(['gym_id' => $this->GYM_ID, 'id' => $pid])->first();
		return $eloquentObj;
	}


	//get all customer name and phone from customer manager
    public function getNamePhone(){
    	$cm = new CustomerManager;
    	$result = $cm->getCustomerNamePhone();
    	return $result;
    }

    //get package of a customer
    public function getPackage($data){
    	$cust = Customer::select('package')->where(['gym_id' => $this->GYM_ID, 'id' => $data['id'], 'is_deleted' => 1])->first();
    	return $cust;
    }

    //update package of customer
    public function updatePackage($data){
    	$cust = Customer::where(['gym_id' => $this->GYM_ID, 'id' => $data['member_id'], 'is_deleted' => 1])->first();
    	$cust->package = $data['package'];
    	$res = $cust->save();
    	return $res;
    }

}


?>