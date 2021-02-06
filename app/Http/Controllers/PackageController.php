<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PackageClasses\PackageManager;
use App\Http\Controllers\CommonClasses\HelperManager;
use Session;

class PackageController extends Controller
{
    use HelperManager;

	private $packageManager;
	public function __construct(){

		$this->middleware('auth');
        $this->middleware('gymstatus');
    	$this->packageManager = new PackageManager();
	}


    //show package adding form
    public function showPackageAddingForm(){
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
    				]);


    	$pack = new Package();
    	$pack->gym_id = auth()->user()->id;
    	$pack->package_name = $data['package_name'];
    	$pack->fee = $data['price'];
        $pack->description = $data['description'];
        $pack->pattern = $data['pattern'];
    	$result = $pack->save();

        if($result == 1){
            Session::flash('msg', '<b>Success!</b> The package data has been created.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The package data has not been created.');
        }


    	$packageList = $this->packageManager->getAllPackageList();
    	return redirect()->back()->with(['packages' => $packageList]);
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
