<?php 

namespace App\Http\Controllers\CustomerClasses;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommonClasses\HelperManager;
use Illuminate\Support\Facades\Cache;
use Image;
use App\Http\Controllers\ProfileInformation;
use Illuminate\Support\Facades\DB;

class CustomerManager{

    use HelperManager;

    private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	//store customer data in database
	public function store($data){
        $pack = Package::select('package_name', 'no_of_days')->where(['id' => $data['package']])->first();
        
		$cust = new Customer();
    	$cust->gym_id = $this->GYM_ID;
    	$cust->username = $this->getRandomUsername();
    	$cust->password = base64_encode($data['password']);
    	$cust->name = $data['fullname'];
    	$cust->phone = $data['phone'];
    	$cust->email = $data['email'];
    	$cust->goal = $data['goal'];
    	$cust->package = $pack->package_name;
        $cust->package_days = $pack->no_of_days;
    	$cust->fee = $data['fee'];
    	$cust->address = $data['address'];
        $cust->state = $data['state'];
        $cust->city = $data['city'];
        $cust->pincode = $data['pincode'];
        $cust->dob = $data['dob'];
        $cust->gender = $data['gender'];
        $cust->remark = $data['remark'];
        $cust->batch = $data['batch'];
        $cust->height = $data['height'];
        $cust->weight = $data['weight'];

        if(isset($data['father_name']))
            $cust->father_name = $data['father_name'];

        if(isset($data['another_phone']))
            $cust->phone_second = $data['another_phone'];

        if(isset($data['marital_status']))
            $cust->marital_status = $data['marital_status'];

        if(isset($data['medical_issue']))
            $cust->medical_issue = $data['medical_issue'];

        if(isset($data['is_employeed']))
            $cust->is_employeed = $data['is_employeed'];

        if(isset($data['place_photo_on_website']))
            $cust->place_photo_on_website = $data['place_photo_on_website'];

        if(isset($data['identity_type']))
            $cust->identity_type = $data['identity_type'];

        if(isset($data['identity_number']))
            $cust->identity_number = $data['identity_number'];

        if(isset($data['customer_image']))
            $cust->customer_image = $this->imageModification($data['customer_image']); 

        if(isset($data['eid'])){
            Enquiry::where(['enquiry_id' => $data['eid'], 'gym_id' => $this->GYM_ID])->update(['convergence' => 1]);
        }
    	return $cust->save();
	}

    //image modification and save to destination location
    private function imageModification($image){
        if(!isset($image)){
            return null;
        }

        $fileName = 'c_' . uniqid() . time() . '.' . strtolower($image->getClientOriginalExtension());
        $location = storage_path('app/public/c_images/'.$fileName);
        $img = Image::make($image);

        if($img->width() < $img->height() && $img->height() >= 300){
            $img->resize(300, 400);
        }
        else{
            $img->width() >= 400 || $img->height() >= 300 ? $img->resize(400, 300) : '';
        }

        $img->save($location);

        return $fileName;
    }


	//generate random values
    private function getRandomUsername(){
        $n=8; 
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    }

    //get all customers of a gym
    public function getAllCustomerList(){
        $cust = new Customer();
        $eloquentObj = $cust->select('*')
                            ->where(['is_deleted' => 1, 'gym_id' => $this->GYM_ID])
                            ->orderByDesc('created_at')
                            ->get();
        return $eloquentObj;
    }

    //get all customers of a gym
    public function getCustomerNamePhone(){
        $cust = new Customer();
        $eloquentObj = $cust->select('id', 'name', 'phone')
                            ->where(['is_deleted' => 1, 'gym_id' => $this->GYM_ID, 'status' => 1])
                            ->orderByDesc('created_at')
                            ->get();
        return $eloquentObj;
    }

    //get all customers data according to column name provided
    public function getAllCustomerData(string $columnName){
        $cust = new Customer;
        $eloquentObj = $cust->select($columnName, 'name')
                            ->where(['gym_id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1])
                            ->get();

        return $eloquentObj;
    }

    // //get all customer count of a gym
    // public function getTotalCustomerCount(){
    //     $cust = new Customer();
    //     $count = $cust->where(['is_deleted' => 1, 'gym_id' => $this->GYM_ID])->count();
    //     return $count;
    // }

    //get active customer count of a gym
    public function getActiveCustomerCount(){
        $cust = new Customer();
        $count = $cust->where(['is_deleted' => 1, 'status' => 1, 'gym_id' => $this->GYM_ID])->count();
        return $count;
    }


    //get name and number of all customers
    public function getAllCustomerNameAndPhone(string $value){
        $itemAdded = false;
        // if(!Cache::has('CUSOTMER_LIST')){
        //     $cust = new Customer;
        //     $custList = $cust->select('name', 'phone')->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1, 'status' => 1])->get();

        //     $itemAdded = Cache::add('CUSOTMER_LIST', $custList, now()->addMinutes(1));
        //     if($itemAdded === true){
        //         $custCollection = $custList;
        //     }
        // }
        // else{
        //     $custCollection = Cache::get('CUSOTMER_LIST');
        // }

        $custCollection = Cache::get('CUSOTMER_LIST', function(){

                            $cust = new Customer;
                            $custList = $cust->select('name', 'phone')->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1, 'status' => 1])->get();

                            $itemAdded = Cache::add('CUSOTMER_LIST', $custList, now()->addMinutes(10));
                            if($itemAdded === true){
                                return $custList;
                            }

                        });

        // logic for searching by letter
        $extracted = array();
        $strArr = str_split($value);
        foreach ($custCollection as $element) {
            $flag = 1;
            foreach ($strArr as $chr) {
                $temp = strpos(strtolower($element->name), strtolower($chr));
                if($temp === false){
                    $flag = 0;
                }   
            }

            if($flag === 1){
                array_push($extracted, [$element->name, $element->phone]); 
            }
        }
        return $extracted;
    }

    //get username of all customer by searching
    public function getAllCustomerUsername(string $value){
        $itemAdded = false;

        $custCollection = Cache::get('CUSTOMER_USERNAMES', function(){
                            $cust = new Customer;
                            $custList = $cust->select('username')->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1])->get();
                            
                            $itemAdded = Cache::add('CUSTOMER_USERNAMES', $custList, now()->addMinutes(10));
                            if($itemAdded === true){
                                return $custList;
                            }
                        });


        // logic for searching by letter
        $extracted = array();
        $strArr = str_split($value);
        foreach ($custCollection as $element) {
            $flag = 1;
            foreach ($strArr as $chr) {
                $temp = strpos(strtolower($element->username), strtolower($chr));
                if($temp === false){
                    $flag = 0;
                }   
            }

            if($flag === 1){
                array_push($extracted, $element->username); 
            }
        }
        return $extracted;
    }


    //changes current status of customer detail
    public function changeCustomerStatus(int $status, $id){
        $cust = new Customer;
        $currentStatus = $this->changeCurrentStatus($cust, $status, $id);
        if($currentStatus == 0){
            Customer::where(['id' => $id])->update(['freezing_history' => DB::raw('freezing_history + 1')]);
        }

        return $currentStatus;
    }

    //delete record of  customer detail
    public function deleteCustomer($id, $password){
        $cust = new Customer;
        $res = $this->deleteRecord($cust, $id, $password);
        return $res;
    }


    //get customer profile data
    public function getCustomer($id){
        $cust = Customer::where(['id' => $id, 'gym_id' => $this->GYM_ID, 'is_deleted' => 1])->first();
        return $cust;
    }

    //update customer profile data
    public function update($data){
        $cust = Customer::where(['id' => $data['d'], 'gym_id' => $this->GYM_ID, 'is_deleted' => 1])->first();
        $cust->name = $data['fullname'];
        $cust->phone = $data['phone'];
        $cust->email = $data['email'];
        $cust->goal = $data['goal'];
        $cust->package = $data['package'];
        $cust->fee = $data['fee'];
        $cust->address = $data['address'];
        $cust->dob = $data['dob'];
        $cust->remark = $data['remark'];
        $cust->gender = $data['gender'];

        if(!empty($data['customer_image']))
            $cust->customer_image = $this->imageModification($data['customer_image']); 

        $res = $cust->save();

        return $res;
    }

    /*

    ===============================
        API CODING STARTS
    ===============================

    */

    //update customer information from api or mobile application
    // public function apiUpdateCustomerInfo($data){
    //     $cust = Customer::where(['id' => $data['customer_id'], 'gym_id' => $data['gym_id'], 'is_deleted' => 1])->first();
    //     $cust->phone = $data['phone'];
    //     $cust->email = $data['email'];
    //     $cust->goal = $data['goal'];
    //     $cust->address = $data['address'];
    //     $cust->dob = $data['dob'];
    //     $cust->gender = $data['gender'];
    //     $cust->height = $data['height'];
    //     $cust->weight = $data['weight'];

    //     $res = $cust->save();

    //     return $res;
    // }


    //save social links to database
    // public function saveSocialLinks($data, $gym_id, $customer_id){
    //     $cust = Customer::where(['id' => $customer_id, 'gym_id' => $gym_id, 'status' => 1, 'is_deleted' => 1])->first();
    //     $cust->facebook = $data['facebook'];
    //     $cust->instagram = $data['instagram'];
    //     $cust->twitter = $data['twitter'];

    //     $res = $cust->update();
    //     return $res;
    // }

    //update customer image from mobile app
    // public function updateCustomerImage($data, $gym_id, $customer_id){
    // 	$cust = Customer::where(['id' => $customer_id, 'gym_id' => $gym_id, 'status' => 1, 'is_deleted' => 1])->first();
    	// $cust->customer_image = $this->imageModification($data['customer_image']); 
    // 	$res = $cust->update();

    // 	return $res;
    // }
    /*

    ===============================
        API CODING ENDS
    ===============================

    */
}

?>