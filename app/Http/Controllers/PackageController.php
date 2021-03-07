<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PackageClasses\PackageManager;
use App\Http\Controllers\CommonClasses\HelperManager;
use Session;
use App\Http\Controllers\ProfileInformation;

class PackageController extends Controller
{
    use HelperManager;

	protected $packageManager;
	public function __construct(){
        $this->middleware(['gymstatus', 'auth:web,employee']);
	}


    //show package adding form
    public function showPackageAddingForm(){
        $this->packageManager = new PackageManager();
    	$packageList = $this->packageManager->getAllPackageList();

    	return view('create.package')->with(['packages' => $packageList]);
    }

    //add package to database
    public function addPackage(Request $request){
    	$data = $request->validate([
    					'package_name' => ['required', 'string', 'regex:/^[\w\s\-\.\,]+$/', 'max:255'],
                        'pattern' => ['required', 'regex:/^[\w\-]+$/', 'max:255'],
                        'description' => ['nullable', 'regex:/^$|^[\w\s\-\.\,]+$/', 'max:255'],
    					'price' => ['required', 'numeric'],
                        'no_of_days' => ['required', 'numeric'],
    				]);


    	$pack = new Package();
    	$pack->gym_id = ProfileInformation::getUser()->id;
    	$pack->package_name = $data['package_name'];
    	$pack->fee = $data['price'];
        $pack->description = $data['description'];
        $pack->pattern = $data['pattern'];
        $pack->no_of_days = $data['no_of_days'];
     	$result = $pack->save();

        if($result == 1){
            Session::flash('msg', '<b>Success!</b> The package data has been created.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The package data has not been created.');
        }

        $this->packageManager = new PackageManager();
    	$packageList = $this->packageManager->getAllPackageList();
    	return redirect()->back()->with(['packages' => $packageList]);
    }

    //show chagne package forms 
    public function showAssignPackageForm(){
        $pm = new PackageManager();
        $customers = $pm->getNamePhone();
        $packages = $pm->getAllPackageNames();
        return view('tasks.package_change')->with(['customers' => $customers, 'packages' => $packages]);
    }


    //get customer package 
    public function getCustomerPackage(Request $request){
        if(!$request->ajax()){
            return "Something went wrong";
        }

        $data = $request->validate([
                                    'id' => ['required', 'numeric'],
                                ]);

        $pm = new PackageManager();
        $package = $pm->getPackage($data);
        if(isset($package)){
            return $package;
        }
        return null;
    }

    //update customer package
    public function changePackage(Request $request){
        $data = $request->validate([
                                    'member_id' => ['required', 'numeric'],
                                    'package' => ['required', 'string', 'max:200'],
                                ]);

        $pm = new PackageManager();
        $result = $pm->updatePackage($data);
        if($result == 1){
            Session::flash('msg', '<b>Success!</b> The package has been updated.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The package has not been updated.');
        }

        return redirect()->back();
    }

    //get and set the status of package from package details to change it 
    public function setStatus(Request $request){
        $data = $request->validate([
                                    's' => ['required', 'numeric'],
                                    'd' => ['required', 'numeric'], 
                                ]);

        $status = $data['s'];
        $id = $data['d'];
        $pack = new Package;
        $currentStatus = $this->changeCurrentStatus($pack, (int)$status, (int)$id);

        if($currentStatus == -1){
            return "failed";
        }

        return $currentStatus;
    }

    //delete package of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];

        $pack = new Package;
        $res = $this->deleteRecord($pack, $id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The package has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The package has not been deleted.');
        }
        
        return redirect()->back();
    }
}
