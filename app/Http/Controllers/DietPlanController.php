<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\Http\Controllers\DietPlanClasses\DietPlanManager;

class DietPlanController extends Controller
{
    public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
    }


    //show diet plan form
    public function showDietForm(){
    	$dpm = new DietPlanManager;
    	$diets = $dpm->getAllDiet();
        // return $diets;
    	return view('create.diet_plan')->with('diets', $diets);
    }

    //save diet plan information
    public function saveDiet(Request $request){
    	$data = $request->validate([
    								'title' => ['required', 'regex:/^[\w\s]+$/'],
    								'plan' => ['required', 'string'],
    							]);

    	$dpm = new DietPlanManager;
    	$result = $dpm->store($data);
    	if($result == 1){
    		Session::flash('msg', '<b>Success!</b> The diet plan has been saved.');
    	}
    	else{
    		Session::flash('msg', '<b>Failed!</b> The diet plan has not been saved.');
    	}

    	return redirect()->back();
    }

    //show assign diet plan form 
    public function showAssignDietForm(){
        $dpm = new DietPlanManager;
        $titles = $dpm->getDietTitle();
        $customer = $dpm->getNamePhone();
        return view('tasks.assign_diet')->with(['titles' => $titles, 'customers' => $customer]);
    }

    //assign diet to customers
    public function assignDiet(Request $request){
        $data = $request->validate([
                                    'diet.*' => ['required', 'numeric'],
                                    'member_id' => ['required', 'numeric'],
                                ]);

        $dpm = new DietPlanManager;
        $result = $dpm->saveAssignDiet($data);

        if($result == 1){
            Session::flash('msg', '<b>Success!</b> Diet plan has been assigned.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The diet plan has not been assigned.');
        }

        return redirect()->back();
    }

    //show assigned diet 
    public function showAssignedDiet(){
        $dpm = new DietPlanManager;
        $customer = $dpm->getNamePhone();
        return view('tasks.show_assigned_diet')->with(['customers' => $customer]);
    }

    //get member diet on given id
    public function getMemberDiet(Request $request){
        $data = $request->validate([
                                    'id' => ['required', 'numeric'],
                                ]);

        $id = $data['id'];

        $dpm = new DietPlanManager;
        $res = $dpm->memberDiet((int)$id);

        return $res;
    }

    //delete diet of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];

        $dpm = new DietPlanManager;
        $res = $dpm->deleteDiet($id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The diet has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The diet has not been deleted.');
        }
        
        return redirect()->back();
    }
}
