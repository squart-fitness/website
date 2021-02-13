<?php 

namespace App\Http\Controllers\WorkoutPlanClasses;

use App\Models\Workout;
use App\Http\Controllers\CommonClasses\HelperManager;
use App\Http\Controllers\CustomerClasses\CustomerManager;

class WorkoutPlanManager{

	use HelperManager;

	//store in database
	public function store($data){
		$wp = new Workout;
		$wp->gym_id = auth()->user()->id;
		$wp->title = $data['title'];
		$wp->workout_description = $data['workout_plan'];
		$result = $wp->save();

		return $result;
	}

	//get all workout plan
	public function getAllWorkout(){
		$wp = Workout::where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])->get();
		return $wp;
	}

	//delete record of  diet
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
    	$wp = Workout::select('id', 'title')->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])->get();
    	return $wp;
    }
}


