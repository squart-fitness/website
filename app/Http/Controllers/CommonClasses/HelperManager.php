<?php 

namespace App\Http\Controllers\CommonClasses;
use Hash;
use App\Http\Controllers\ProfileInformation;

trait HelperManager{

	public function changeCurrentStatus($model, $status, $id){
		$defaultStatus = 0;
        if($status === 0){
            $defaultStatus = 1;
        }
        else if($status === 1){
            $defaultStatus = 0;
        }
        else{
            return -1;
        }

        $result = $model->where(['id' => $id, 'gym_id' => auth()->user()->id])->update(['status' => $defaultStatus]);

        if($result == 1){
        	return $defaultStatus;
        }

        return -1;
	}


	public function deleteRecord($model, $id, $password){
        if(!Hash::check($password, auth()->user()->password)){
            return -1;
        }

        $result = $model->where(['id' => $id, 'gym_id' => auth()->user()->id])->update(['is_deleted' => 0]);
        return $result;
	}
}

?>