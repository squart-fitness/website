<?php 
namespace App\Http\Controllers\DietPlanClasses;

use App\Models\DietPlan;
use App\Models\AssignedDiet;
use App\Http\Controllers\CommonClasses\HelperManager;
use App\Http\Controllers\CustomerClasses\CustomerManager;
use App\Http\Controllers\ProfileInformation;

class DietPlanManager{

    use HelperManager;

    private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	// store diet in database
	public function store($data){
		$dp = new DietPlan;
		$dp->gym_id = $this->GYM_ID;
		$dp->title = $data['title'];
		$dp->diet_description = $data['plan'];

		$res = $dp->save();
		return $res;
	}


	// get diets from database
	public function getAllDiet(){
		$res = DietPlan::where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])->get();
		return $res;
	}


	//delete record of  diet
    public function deleteDiet($id, $password){
        $dp = new DietPlan;
        $res = $this->deleteRecord($dp, $id, $password);
        return $res;
    }

    //get name of all diet plans of a single gym
    public function getDietTitle(){
    	$res = DietPlan::select('id', 'title')->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])->get();
    	return $res;
    }

    //get all customer name and phone from customer manager
    public function getNamePhone(){
    	$cm = new CustomerManager;
    	$result = $cm->getCustomerNamePhone();
    	return $result;
    }

    //assign diet to customer and save in database
    public function saveAssignDiet($data){
        $arr = array();
        foreach ($data['diet'] as $value) {
            array_push($arr, ['gym_id' => $this->GYM_ID, 'customer_id' => $data['member_id'], 'dietplan_id' => $value, 'created_at' => now(), 'updated_at' => now()]);
        }

        $result = AssignedDiet::insert($arr);
        return $result;
    }

    //get member diet plan
    public function memberDiet($id){
        $diets_id = AssignedDiet::select('dietplan_id')
                                ->where(['gym_id' => $this->GYM_ID, 'customer_id' => $id, 'is_deleted' => 1])
                                ->get();

        $id = array();
        foreach($diets_id as $value){
            array_push($id, $value->dietplan_id);
        }

        $diet_list = DietPlan::select('title')
                                ->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])
                                ->whereIn('id', $id)
                                ->get();
        return $diet_list;
    }

    /*
        =================
        API CODING
        =================
    */

    //get member diet plan
    // public function memberAllDiet($gym_id, $id){
    //     $diets_id = AssignedDiet::select('dietplan_id')
    //                             ->where(['gym_id' => $gym_id, 'customer_id' => $id, 'is_deleted' => 1])
    //                             ->get();

    //     $id = array();
    //     foreach($diets_id as $value){
    //         array_push($id, $value->dietplan_id);
    //     }

    //     $diet_list = DietPlan::where(['gym_id' => $gym_id, 'is_deleted' => 1])
    //                            ->whereIn('id', $id)
    //                            ->get();
    //     return $diet_list;
    // }

}

?>