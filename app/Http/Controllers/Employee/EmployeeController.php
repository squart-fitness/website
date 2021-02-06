<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employee\EmployeeClasses\EmployeeManager;
use Illuminate\Support\Facades\Auth;

use Session;

class EmployeeController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'gymstatus'])->except('showLoginEmployee', 'loginEmployee');
    }


    //shows employee adding form
    public function showAddingForm(){
		return view('employee.add_employee');
    }

    /* Save employee data to database
        This function is calling from employee adding form request
    */

    public function saveEmployee(Request $request){
        // return $request->remark;
        $data = $request->validate([
                                    'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
                                    'phone' => ['required', 'numeric', 'digits:10'],
                                    'email' => ['required', 'email', 'string', 'max:255'],
                                    'pass' => ['required', 'string', 'min:3', 'max:50'],
                                    'salary' => ['required', 'numeric'],
                                    'role' => ['required', 'numeric'],
                                    'designation' => ['required', 'regex:/^[\w\s\-]+$/'],
                                    'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/]+$/', 'max:255'],
                                    'gender' => ['required', 'alpha', 'max:100'],
                                    'remark' => ['nullable', 'regex:/^$|^[\w\s\-]+$/'],
                                    'dob' => ['nullable', 'before: -18 years', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'employee_image' => ['nullable', 'file', 'image', 'max:2048'],
                                ]);

        $employee = new EmployeeManager;
        $result = $employee->storeEmployee($data);
        if($result == 1){
            Session::flash('msg', '<b>Success!</b> The employee data has been saved.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The employee data has not been saved.');
        }

        return redirect()->back();
    }

    //show login employee form
    public function showLoginEmployee(){
        // auth('employee')->logout();
        var_dump(auth('employee')->check());
        return view('employee.employee_login');
    }

    //login employee
    public function loginEmployee(Request $request){
        $email = $request->email;
        $pass = $request->password;
        $credentials = ['employee_email' => $email, 'password' => $pass];

        // return $credentials;
        if (Auth::guard('employee')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashoard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    //shows numebr of employee lists 
    public function showEmployeeList(){
        $employeeManager = new EmployeeManager;
        $result = $employeeManager->getAllEmployee();
		return view('employee.employee_list')->with('employees', $result);
    }

    //show Usernames
    public function showUsernames(Request $request){
        $employeeManager = new EmployeeManager();
        return $employeeManager->getAllCustomerUsername($request->value);
    }


    //show customer name and number to take payment
    public function showEmployeeNameAndNumber(Request $request){
        $data = $request->validate([
                                    'username' => ['required', 'alpha_num', 'string'],
                                ]);
        $employeeManager = new EmployeeManager();
        $employeeData = $employeeManager->getEmployeeNameAndNumber($data['username']);
        return $employeeData;
    }


    //save payment of employee to database
    public function saveSalary(Request $request){
        $data = $request->validate([
                                    'employee_id' => ['required'],
                                    'pay_mode' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                                    'total_amt' => ['required', 'regex:/^[0-9]+$/'],
                                    'paid_amt' => ['required', 'regex:/^[0-9]+$/'],
                                    'per_start' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'per_end' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                ]);

        $employeeManager = new EmployeeManager();
        $result = $employeeManager->addPaymentOfEmployee($data);
        if($result == 1){
            Session::flash('msg', '<b>Success!</b> The employee salary has been saved.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The employee salary has not been saved.');
        }
        return redirect()->back();
    }


    //shows employee salary Form
    public function showSalaryForm(){
		return view('employee.employee_salary');
    }

    //shows employee salary detials
    public function showSalaryDetail(){
        $employeeManager = new EmployeeManager();
        $result = $employeeManager->getSalaryDetailOfAll();
		return view('employee.employee_salary_details')->with('salaries', $result);
    }

    //shows employee salary in months 
    public function showEmployeeSalaryInMonth(Request $request){
        $data = $request->validate([
                                    'month' => ['required', 'numeric'],
                                ]);

        $employeeManager = new EmployeeManager();
        $salaryDetail = $employeeManager->getSalarytailByMonth((int)$data['month']);
        return $salaryDetail;
    }

    //show employee salary in range of date
    public function showEmployeeByDate(Request $request){
        $data = $request->validate([
                                    'initial' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'final' => ['required', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                ]);

        $employeeManager = new EmployeeManager;
        $salary = $employeeManager->getSalaryByDate($data['initial'], $data['final']);
        return $salary;
    }


    //gets the status of employee from employee details to change it 
    public function setStatus(Request $request){
        $data = $request->validate([
                                    's' => ['required', 'numeric'],
                                    'd' => ['required', 'numeric'], 
                                ]);

        $status = $data['s'];
        $id = $data['d'];
        $employee = new EmployeeManager;
        $currentStatus = $employee->changeEmployeeStatus($status, $id);

        if($currentStatus == -1){
            return "failed";
        }

        return $currentStatus;
    }

     //delete employee of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];
        
        $employee = new EmployeeManager;
        $res = $employee->deleteEmployee($id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The employee has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The employee has not been deleted.');
        }
        
        return redirect()->back();
    }


    //show update form of customer of a gym
    public function showUpdateForm(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                ]);

        $id = $data['d'];
        $employee = new EmployeeManager;
        $profile = $employee->getEmployeeData((int)$id);

        if(empty($profile)){
            return redirect()->route('employee_list');
        }

        // return $profile;
        return view('employee.update_employee')->with('profile', $profile);
    }

    //update customer data of a gym
    public function updateEmployee(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'],
                                    'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
                                    'phone' => ['required', 'numeric', 'digits:10'],
                                    'email' => ['required', 'email', 'string', 'max:255'],
                                    'salary' => ['required', 'numeric'],
                                    'role' => ['required', 'numeric'],
                                    'designation' => ['required', 'regex:/^[\w\s\-]+$/'],
                                    'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/]+$/', 'max:255'],
                                    'gender' => ['required', 'alpha', 'max:100'],
                                    'remark' => ['nullable', 'regex:/^$|^[\w\s\-]+$/'],
                                    'dob' => ['nullable', 'regex:/^\d{4}\-\d{2}\-\d{2}$/'],
                                    'employee_image' => ['nullable', 'file', 'image', 'max:2048'],
                                ]);
        
        $employee = new EmployeeManager;
        $res = $employee->update($data);

        if(empty($res)){
            return redirect()->route('employee_list');
        }

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The employee has been <i>updated</i>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The employee has not been <i>updated</i>.');
        }

        return redirect()->back();

    }
}
