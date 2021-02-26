<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ProfileInformation;
use App\Models\GymStaffPermission;

class ApplicationFeature extends Model
{
    use HasFactory;

    //compare features of application with staff features
    public function compareFeatures($feature){
    	$af = ApplicationFeature::select('id')->where(['features' => $feature, 'status' => 1, 'is_deleted' => 1])->first();
    	$feature_id = 0;
    	if(!isset($af)){
    		return 0;
    	}

    	$feature_id = $af->id;
    	$staff_id = auth('employee')->user()->id;
    	$gym_id = ProfileInformation::getUser()->id;

    	$gsp = GymStaffPermission::where(['gym_id' => $gym_id, 'staff_id' => $staff_id, 'feature_id' => $feature_id])->first();
    	if(isset($gsp)){
    		return 1;
    	}
    	else{
    		return -1;
    	}
    }
}
