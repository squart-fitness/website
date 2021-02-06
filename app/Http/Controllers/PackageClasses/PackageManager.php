<?php 

namespace App\Http\Controllers\PackageClasses;
use App\Models\Package;


class PackageManager{
	
	//gives list of all packages
	public function getAllPackageList(){
		$pack = new Package();
		$eloquentObj = $pack->select('*')->where(['gym_id' => auth()->user()->id, 'is_deleted' => '1'])->get();
		return $eloquentObj;
	}

	//gives list of all packages names only
	public function getAllPackageNames(){
		$pack = new Package();
		$eloquentObj = $pack->select('package_name', 'id')->where(['gym_id' => auth()->user()->id, 'is_deleted' => '1'])->get();
		return $eloquentObj;
	}	

	//gives specific package fee
	public function getSpecificPackageFee($pid){
		$pack = new Package();
		$eloquentObj = $pack->select('fee')->where(['gym_id' => auth()->user()->id, 'id' => $pid])->first();
		return $eloquentObj;
	}

}


?>