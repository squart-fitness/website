<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

//custom imports
use App\Models\User;
use App\Models\Employee;
use App\Models\ApplicationFeature;
use App\Http\Controllers\ProfileInformation;
use App\Models\GymStaffPermission;

class EmployeePermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function before(Model $model){
        if($model instanceof User){
            return true;
        }
    }

    //check for permission 
    public function checkPermission(Employee $emp, $featureName){
        return $this->compareFeatures($featureName);
    }


    //compare features of application with staff features
    public function compareFeatures($feature){
        $af = ApplicationFeature::select('id')->where(['features' => $feature, 'status' => 1, 'is_deleted' => 1])->first();
        $feature_id = 0;

        //returns message if given feature is not available
        if(!isset($af)){
            dd('Something went wrong.');
        }

        $feature_id = $af->id;
        $staff_id = auth('employee')->user()->id;
        $gym_id = ProfileInformation::getUser()->id;

        $gsp = GymStaffPermission::where(['gym_id' => $gym_id, 'staff_id' => $staff_id, 'feature_id' => $feature_id])->first();

        //returns true if given feature permission found for a employee else returns false
        if(isset($gsp)){
            return true;
        }
        else{
            return false;
        }
    }
}
