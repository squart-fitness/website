<?php 
namespace App\Http\Controllers\Employee\EmployeeClasses;

use App\Models\Employee;
use App\Models\EmployeePayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonClasses\HelperManager;
use Illuminate\Support\Facades\Hash;

use Image;

class EmployeeManager{

	use HelperManager;

	//saving employee full form data to database
	public function storeEmployee($data){
		$employee = new Employee();
		$employee->gym_id = auth()->user()->id;
		$employee->username = 'EMP'.$this->getRandomUsername();
		$employee->password = Hash::make($data['pass']);
		$employee->employee_name = $data['fullname'];
		$employee->employee_phone = $data['phone'];
		$employee->employee_email = $data['email'];
		$employee->salary = $data['salary'];
		$employee->role = $data['role'];
		$employee->designation = $data['designation'];
		$employee->address = $data['address'];
		$employee->gender = $data['gender'];
		$employee->remark = $data['remark'];
		$employee->dob = $data['dob'];

		if(!empty($data['employee_image']))
	        $employee->employee_image = $this->imageModification($data['employee_image']); 
		
		$res = $employee->save();
		return $res;
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

    //image modification and save to destination location
    private function imageModification($image){
        if(!isset($image)){
            return null;
        }

        $fileName = 'e_' . uniqid() . time() . '.' . strtolower($image->getClientOriginalExtension());
        $location = storage_path('app/public/e_images/'.$fileName);
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

    //give all employees in a gym
    public function getAllEmployee(){
    	$employee = new Employee;
    	$employeeCollection = $employee->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])->latest()->get();
    	return $employeeCollection;
    }

    //give all active employees in a gym
    public function getActiveEmployees(){
    	$employee = new Employee;
    	$employeeCollection = $employee->select('id', 'username', 'employee_name as name', 'employee_phone as phone', 'employee_email as email', 'designation')
    								   ->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1, 'status' => 1])
    								   ->get();
    	return $employeeCollection;
    }

    //get all employees count
    public function getTotalEmployeeCount(){
    	$emp = new Employee;
    	$count = $emp->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1, 'status' => 1])->count();
    	return $count;
    }

 	 //get username of all employee by searching
    public function getAllCustomerUsername(string $value){
        $employee = new Employee;
        $employeeCollection = $employee->select('username')->where(['gym_id' => auth()->user()->id, 'is_deleted' => 1])->get();

        $extracted = array();
        $strArr = str_split($value);
        foreach ($employeeCollection as $element) {
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


    //store employee payment data
	public function addPaymentOfEmployee($data){
		$pay = new EmployeePayment;
		$pay->gym_id = auth()->user()->id;
		$pay->employee_id = $data['employee_id'];
		$pay->payment_mode = $data['pay_mode'];
		$pay->total_amount = $data['total_amt'];
		$pay->paid_amount = $data['paid_amt'];
		$pay->due_amount = $data['total_amt'] - $data['paid_amt'];
		$pay->period_start = $data['per_start'];
		$pay->period_end = $data['per_end'];
		return $pay->save();
 	}


 	//give single employee name and number with due amount
	public function getEmployeeNameAndNumber($memberID){
		$employee = new Employee;
		$temp = $employee->where(['username' => $memberID, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first()->employeePayment->first();
		if(!isset($temp)){
			$username = $employee->select('id', 'salary')->where(['username' => $memberID, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
			return $username;
		}

		$custEloquent = DB::table('employee_payment')
							->join('employees', 'employee_payment.employee_id', '=', 'employees.id')
							->select('employee_payment.due_amount', 'employee_payment.period_end', 'employees.id', 'employees.employee_name', 'employees.employee_phone', 'employees.salary')
							->where(['employees.gym_id' => auth()->user()->id, 'employees.username' => $memberID, 'employees.is_deleted' => 1])
							->orderByDesc('employee_payment.created_at')
							->limit(1)
							->get();

		return ($custEloquent);
	}


	//give salary detail of all employees of a gym
	public function getSalaryDetailOfAll(){
		$salary = DB::table('employees')
						->join('employee_payment', 'employees.id', '=', 'employee_payment.employee_id')
						->select('employee_payment.*', 'employees.username', 'employees.employee_name', 'employees.employee_phone')
						->where(['employee_payment.gym_id' => auth()->user()->id, 'employee_payment.is_deleted' => 1, 'employee_payment.status' => 1])
						->get();

		return $salary;
	}

	//give salary detail of all employee of a gym in a given month
	public function getSalarytailByMonth(int $monthNumber){
		$salary = DB::table('employees')
						->join('employee_payment', 'employees.id', '=', 'employee_payment.employee_id')
						->select('employee_payment.*', 'employees.username', 'employees.employee_name', 'employees.employee_phone')
						->where(['employee_payment.gym_id' => auth()->user()->id, 'employee_payment.is_deleted' => 1, 'employee_payment.status' => 1])
						->whereRaw('MONTH(employee_payment.created_at) = ?', [$monthNumber])
						->get();

		return $salary;
	}

	//give salary details in range of date
	public function getSalaryByDate($initial, $final){
		$salary = DB::table('employees')
						->join('employee_payment', 'employees.id', '=', 'employee_payment.employee_id')
						->select('employee_payment.*', 'employees.username', 'employees.employee_name', 'employees.employee_phone')
						->where(['employee_payment.gym_id' => auth()->user()->id, 'employee_payment.is_deleted' => 1, 'employee_payment.status' => 1])
						->whereRaw('employee_payment.created_at > ? AND employee_payment.created_at < ?', [$initial, $final])
						->orderByDesc('employee_payment.created_at')
						->get();

		return $salary;
	}


	//changes current status of enquiry detail
 	public function changeEmployeeStatus(int $status, $id){
 		$emp = new Employee;
 		$currentStatus = $this->changeCurrentStatus($emp, $status, $id);
 		return $currentStatus;
 	}


 	//delete record of  employee detail
 	public function deleteEmployee($id, $password){
 		$emp = new Employee;
 		$res = $this->deleteRecord($emp, $id, $password);
 		return $res;
 	}

 	//get single employee profile data on id
 	public function getEmployeeData($id){
 		$emp = Employee::where(['id' => $id, 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
 		return $emp;
 	}

 	//update employee profile data
 	public function update($data){
 		$employee = Employee::where(['id' => $data['d'], 'gym_id' => auth()->user()->id, 'is_deleted' => 1])->first();
 		$employee->employee_name = $data['fullname'];
		$employee->employee_phone = $data['phone'];
		$employee->employee_email = $data['email'];
		$employee->salary = $data['salary'];
		$employee->role = $data['role'];
		$employee->designation = $data['designation'];
		$employee->address = $data['address'];
		$employee->gender = $data['gender'];
		$employee->dob = $data['dob'];
		$employee->remark = $data['remark'];
        $employee->employee_image = $this->imageModification($data['employee_image']); 
		
		$res = $employee->update();
		return $res;
 	}
}

?>