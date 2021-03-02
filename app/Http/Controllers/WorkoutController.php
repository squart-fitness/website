<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

//my imports
use  App\Http\Controllers\WorkoutPlanClasses\WorkoutPlanManager;

class WorkoutController extends Controller
{
    public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
    }

    //show create workout form
    public function showWorkoutForm(){
    	$wpm = new WorkoutPlanManager;
    	$workout_plans = $wpm->getAllWorkout();
    	return view('create.workout_plan')->with('workouts', $workout_plans);
    }

    //save workout 
    public function saveWorkout(Request $request){
    	$data = $request->validate([
    								'title' => ['required', 'regex:/^[\w\s]+$/'],
    								'workout_plan' => ['required', 'string'],
    							]);

    	$wpm = new WorkoutPlanManager;
    	$result = $wpm->store($data);
    	if($result == 1){
    		Session::flash('msg', '<b>Success!</b> The workout plan has been saved.');
    	}
    	else{
    		Session::flash('msg', '<b>Failed!</b> The workout plan has not been saved.');
    	}

    	return redirect()->back();
    }


    //delete diet of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];

        $wpm = new WorkoutPlanManager;
        $res = $wpm->deleteWorkout($id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The workout plan has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The workout plan has not been deleted.');
        }
        
        return redirect()->back();
    }

    //assign workout to customers
    public function assignWorkout(Request $request){
        $data = $request->validate([
                                    'workout.*' => ['required', 'numeric'],
                                    'member_id' => ['required', 'numeric'],
                                ]);

        $dpm = new WorkoutPlanManager;
        $result = $dpm->saveAssignWorkout($data);

        if($result == 1){
            Session::flash('msg', '<b>Success!</b> Workout plan has been assigned.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The workout plan has not been assigned.');
        }

        return redirect()->back();
    }

    //show assign workout form
    public function showAssignWorkoutForm(){
        $wpm = new WorkoutPlanManager;
        $titles = $wpm->getTitles();
        $customers = $wpm->getNamePhone();
        return view('tasks.assign_workout')->with(['customers' => $customers, 'titles' => $titles]);
    }

    //show assigned workout 
    public function showAssignedWorkout(){
        $dpm = new WorkoutPlanManager;
        $customer = $dpm->getNamePhone();
        return view('tasks.show_assigned_workout')->with(['customers' => $customer]);
    }

    //get members workout
    public function getMemberWorkout(Request $request){
        $data = $request->validate([
                                    'id' => ['required', 'numeric'],
                                ]);

        $id = $data['id'];

        $wpm = new WorkoutPlanManager;
        $res = $wpm->memberWorkout((int)$id);

        return $res;
    }
}
