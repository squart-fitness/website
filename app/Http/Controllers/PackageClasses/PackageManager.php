<?php 

namespace App\Http\Controllers\PackageClasses;
use App\Models\Package;
use App\Http\Controllers\ProfileInformation;

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

}


?>