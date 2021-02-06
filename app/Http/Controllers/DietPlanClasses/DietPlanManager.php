<?php 
namespace App\Http\Controllers\DietPlanClasses;

use App\Models\DietPlan;
use App\Http\Controllers\CommonClasses\HelperManager;

class DietPlanManager{

    use HelperManager;

	// store diet in database
	public function store($data){
		$dp = new DietPlan;
		$dp->gym_id = auth()->user()->id;
		$dp->title = $data['title'];
		$dp->diet_description = $data['plan'];

		$res = $dp->save();
		return $res;
	}


	// get diets from database
	public function getAllDiet(){
		$res = DietPlan::where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])->get();
		return $res;
	}


	//delete record of  diet
    public function deleteDiet($id, $password){
        $dp = new DietPlan;
        $res = $this->deleteRecord($dp, $id, $password);
        return $res;
    }

}

?>