<?php 
namespace App\Http\Controllers\EnquiryClasses;

use App\Http\Controllers\CommonClasses\HelperManager;
use App\Models\Enquiry;

class EnquiryManager{

	use HelperManager;

	// private const SINGLE_TYPE = 'singlegym';
	// private const GLOBAL_TYPE = 'globalgym';
	//store enquiry data to database
	public function storeSingleEnquiry($data){
		$enquiry = new Enquiry;
		$enquiry->gym_id = auth()->user()->id;
		$enquiry->customer_name = $data['fullname'];
		$enquiry->customer_phone = $data['phone'];
		$enquiry->customer_address = $data['address'];
		$enquiry->goal = $data['goal'];
		$enquiry->gender = $data['gender'];
		$enquiry->source_of_enquiry = $data['soe'];
		$enquiry->height = $data['height'];
		$enquiry->weight = $data['weight'];
		$enquiry->enquiry_id = $this->generateRandomId();

		if(isset($data['plan_interested']))
			$enquiry->plan_interested = $data['plan_interested'];

		if(isset($data['response']))
			$enquiry->response = $data['response'];

		if(isset($data['follow_up_date']))
			$enquiry->followup_date = $data['follow_up_date'];

		if(isset($data['trail_date']))
			$enquiry->trail_date = $data['trail_date'];

		if(isset($data['query']))
			$enquiry->query = $data['query'];

		if(isset($data['remarks']))
			$enquiry->remarks = $data['remarks'];


		$res = $enquiry->save();

		return $res;
	}

	//update enquiry
	public function updateEnq($data){
		$enquiry = Enquiry::where(['id' => $data['d'], 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
		$enquiry->customer_name = $data['fullname'];
		$enquiry->customer_phone = $data['phone'];
		$enquiry->customer_address = $data['address'];
		$enquiry->goal = $data['goal'];
		$enquiry->gender = $data['gender'];
		$enquiry->source_of_enquiry = $data['soe'];
		$enquiry->height = $data['height'];
		$enquiry->weight = $data['weight'];
		$enquiry->plan_interested = $data['plan_interested'];
		$enquiry->response = $data['response'];
		$enquiry->followup_date = $data['follow_up_date'];
		$enquiry->trail_date = $data['trail_date'];
		$enquiry->query = $data['query'];
		$enquiry->remarks = $data['remarks'];

		$res = $enquiry->update();
		return $res;
	}

	//generate random enquiry id
	private function generateRandomId(){
		$m=3; 
        $numbers = '0123456789'; 
        $randomString = ''; 

        for ($i = 0; $i < $m; $i++) { 
            $index = rand(0, strlen($numbers) - 1); 
            $randomString .= $numbers[$index]; 
        } 
      	
      	$date = date_create(NULL, timezone_open('Asia/Kolkata'));
        $day = date_format($date, 'dmY');

        $randomString .= '-'.$day;
        return $randomString; 
	}

	//get enquiry by enquiry_id 
	public function getEnquiryByUniqueId($enquiry_id){
		$enquiry = Enquiry::where(['enquiry_id' => $enquiry_id, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
		return $enquiry;
	}

	//get single enquiry detials
	public function getSingleEnquiry($id){
		$enquiry = Enquiry::where(['id' => $id, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
		return $enquiry;
	}

	//give all enquiries of a single gym
	public function getEnquiry(){
		$enquiry = new Enquiry;
		$enquiryList = $enquiry->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])
							   ->latest()
							   ->paginate(20);

		return $enquiryList;
	}

	//give single enquiry data
	public function getEnquiryProfile($eid){
		$enquiry = Enquiry::where(['enquiry_id' => $eid, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
		return $enquiry;
	}

	//give enquiries according to month
	public function getEnquiryDetailByMonth($startDate, $endDate){
 		$enquiry = new Enquiry;
 		$enquiryCollection = $enquiry->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1, 'status' => 1])
 									 ->where('created_at', '>=', $startDate)
 									 ->where('created_at', '<=', $endDate)
									 ->orderByDesc('created_at')
 									 ->get();
 		return $enquiryCollection;

 	}

 	//get enquiries according to filteration
 	public function getFilteredEnquiry($filterBy, $filterValue){
 		$enquiry = new Enquiry;
 		$columnName = "";
 		if($filterBy == 'name')
 			$columnName = 'customer_name';

 		if($filterBy == 'phone')
 			$columnName = 'customer_phone';

 		if($filterBy == 'goal')
 			$columnName = 'goal';

 		if($filterBy == 'plan')
 			$columnName = 'plan_interested';

 		if($filterBy == 'followUp')
 			$columnName = 'followup_date';

 		if($filterBy == 'trail')
 			$columnName = 'trail_date';

 		if($filterBy == 'remarks')
 			$columnName = 'remarks';

 		if($filterBy == 'address')
 			$columnName = 'customer_address';

 		if($filterBy == 'height')
 			$columnName = 'height';

 		if($filterBy == 'weight')
 			$columnName = 'weight';

 		if($filterBy == 'enquiryid')
 			$columnName = 'enquiry_id';

 		if($filterBy == 'gender')
 			$columnName = 'gender';

 		$enquiryCollection = $enquiry->where($columnName, $filterValue)
 									 ->orderByDesc('created_at')
 									 ->get();
 		return $enquiryCollection;
 	}


 	//changes current status of enquiry detail
 	public function changeEnquiryStatus(int $status, $id){
 		$enquiry = new Enquiry;
 		$currentStatus = $this->changeCurrentStatus($enquiry, $status, $id);
 		return $currentStatus;
 	}

 	//delete record of  enquiry detail
 	public function deleteEnquiry($id, $password){
 		$enquiry = new Enquiry;
 		$res = $this->deleteRecord($enquiry, $id, $password);
 		return $res;
 	}


 	//get all enquiries count
 	public function getEnquiryCount(){
 		$enquiry = Enquiry::where(['is_deleted' => 1, 'status' => 1, 'gym_id' => auth()->user()->id])->count();
 		return $enquiry;
 	}

 	//get all enquiry convergence report
 	public function getEnquiryConvergence(){
 		$enquiry = Enquiry::where(['gym_id' => auth()->user()->id, 'status' => 1, 'is_deleted' => 1, 'convergence' => 1])->latest()->get();
 		return $enquiry;
 	}
}

?>