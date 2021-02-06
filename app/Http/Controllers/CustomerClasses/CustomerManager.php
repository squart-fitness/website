<?php 

namespace App\Http\Controllers\CustomerClasses;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommonClasses\HelperManager;
use Illuminate\Support\Facades\Cache;
use Image;


class CustomerManager{

    use HelperManager;

	//store customer data in database
	public function store($data){
        $pack = Package::select('package_name')->where(['id' => $data['package']])->first();
        
		$cust = new Customer();
    	$cust->gym_id = auth()->user()->id;
    	$cust->username = $this->getRandomUsername();
    	$cust->password = base64_encode($data['password']);
    	$cust->name = $data['fullname'];
    	$cust->phone = $data['phone'];
    	$cust->email = $data['email'];
    	$cust->goal = $data['goal'];
    	$cust->package = $pack->package_name;
    	$cust->fee = $data['fee'];
    	$cust->address = $data['address'];
        $cust->dob = $data['dob'];
        $cust->gender = $data['gender'];
        $cust->remark = $data['remark'];
        $cust->batch = $data['batch'];
        $cust->height = $data['height'];
        $cust->weight = $data['weight'];

        if(!empty($data['customer_image']))
            $cust->customer_image = $this->imageModification($data['customer_image']); 

        if(!empty($data['eid'])){
            Enquiry::where(['enquiry_id' => $data['eid'], 'gym_id' => auth()->user()->id])->update(['convergence' => 1]);
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
                            ->where(['is_deleted' => 1, 'gym_id' => auth()->user()->id])
                            ->orderByDesc('created_at')
                            ->get();
        return $eloquentObj;
    }

    //get all customers data according to column name provided
    public function getAllCustomerData(string $columnName){
        $cust = new Customer;
        $eloquentObj = $cust->select($columnName, 'name')
                            ->where(['gym_id' => auth()->user()->id, 'status' => 1, 'is_deleted' => 1])
                            ->get();

        return $eloquentObj;
    }

    // //get all customer count of a gym
    // public function getTotalCustomerCount(){
    //     $cust = new Customer();
    //     $count = $cust->where(['is_deleted' => 1, 'gym_id' => auth()->user()->id])->count();
    //     return $count;
    // }

    //get active customer count of a gym
    public function getActiveCustomerCount(){
        $cust = new Customer();
        $count = $cust->where(['is_deleted' => 1, 'status' => 1, 'gym_id' => auth()->user()->id])->count();
        return $count;
    }


    //get name and number of all customers
    public function getAllCustomerNameAndPhone(string $value){
        $itemAdded = false;
        // if(!Cache::has('CUSOTMER_LIST')){
        //     $cust = new Customer;
        //     $custList = $cust->select('name', 'phone')->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1, 'status' => 1])->get();

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
                            $custList = $cust->select('name', 'phone')->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1, 'status' => 1])->get();

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
                            $custList = $cust->select('username')->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])->get();
                            
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
        $cust = Customer::where(['id' => $id, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
        return $cust;
    }

    //update customer profile data
    public function update($data){
        $cust = Customer::where(['id' => $data['d'], 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
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
    public function apiUpdateCustomerInfo($data){
        
    }

    /*

    ===============================
        API CODING ENDS
    ===============================

    */
}

?>