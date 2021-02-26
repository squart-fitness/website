<?php 

namespace App\Http\Controllers\WorkoutPlanClasses;

use App\Models\Workout;
use App\Models\AssignedWorkout;
use App\Http\Controllers\CommonClasses\HelperManager;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\ProfileInformation;

class WorkoutPlanManager{

	use HelperManager;

    private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	//store in database
	public function store($data){
		$wp = new Workout;
		$wp->gym_id = $this->GYM_ID;
		$wp->title = $data['title'];
		$wp->workout_description = $data['workout_plan'];
		$result = $wp->save();

		return $result;
	}

	//get all workout plan
	public function getAllWorkout(){
		$wp = Workout::where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])->get();
		return $wp;
	}

	//delete record of  workout
    public function deleteWorkout($id, $password){
        $dp = new Workout;
        $res = $this->deleteRecord($dp, $id, $password);
        return $res;
    }

    //get all customer name and phone from customer manager
    public function getNamePhone(){
    	$cm = new CustomerManager;
    	$result = $cm->getCustomerNamePhone();
    	return $result;
    }

    //get title name from workout
    public function getTitles(){
    	$wp = Workout::select('id', 'title')->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])->get();
    	return $wp;
    }

    //assign workout to customer and save in database
    public function saveAssignWorkout($data){
        $arr = array();
        foreach ($data['workout'] as $value) {
            array_push($arr, ['gym_id' => $this->GYM_ID, 'customer_id' => $data['member_id'], 'workout_plan_id' => $value, 'created_at' => now(), 'updated_at' => now()]);
        }

        $result = AssignedWorkout::insert($arr);
        return $result;
    }

     //get member workout plan
    public function memberWorkout($id){
        $workout_planID = AssignedWorkout::select('workout_plan_id')
                                ->where(['gym_id' => $this->GYM_ID, 'customer_id' => $id, 'is_deleted' => 1])
                                ->get();

        $id = array();
        foreach($workout_planID as $value){
            array_push($id, $value->workout_plan_id);
        }

        $workout_list = Workout::select('title')
                                ->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])
                                ->whereIn('id', $id)
                                ->get();
        return $workout_list;
    }

    //get member workout plan
    public function memberAllWorkout($gym_id, $id){
        $workout_planID = AssignedWorkout::select('workout_plan_id')
                                ->where(['gym_id' => $gym_id, 'customer_id' => $id, 'is_deleted' => 1])
                                ->get();

        $id = array();
        foreach($workout_planID as $value){
            array_push($id, $value->workout_plan_id);
        }

        $workout_list = Workout::where(['gym_id' => $gym_id, 'is_deleted' => 1])
                                ->whereIn('id', $id)
                                ->get();
        return $workout_list;
    }
}


