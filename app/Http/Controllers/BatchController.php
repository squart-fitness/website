<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use Session;
use App\Http\Controllers\CommonClasses\HelperManager;
use App\Http\Controllers\ProfileInformation;

class BatchController extends Controller
{
    use HelperManager;

    public function __construct(){
    	$this->middleware(['gymstatus', 'auth:web,employee']);
    }

    public function index(){
    	$bat = $this->batchRecord();
    	return view('create.batch')->with('batches', $bat);
    }

    //save batch information
    public function save(Request $request){
    	$data = $request->validate([
    								'batch_name' => ['required', 'regex:/^[\w\s\-\:]+$/'],
    								'start_time' => ['required', 'regex:/^(\d{1,2}\s\:\s\d{2}\s)AM|PM$/'],
    								'end_time' => ['required', 'regex:/^(\d{1,2}\s\:\s\d{2}\s)AM|PM$/'],
    								'description' => ['required', 'regex:/^[\w\s\.\,\-\:\=\+]+$/'],
    							]);

    	$bat = new Batch;
    	$bat->gym_id = ProfileInformation::getUser()->id;
    	$bat->batch_name = $data['batch_name'];
    	$bat->start_time = $data['start_time'];
    	$bat->end_time   = $data['end_time'];
    	$bat->description= $data['description'];
    	$res = $bat->save();

    	if($res == 1){
    		Session::flash('msg', '<b>Success!</b> Batch has been created.');
    	}
    	else{
    		Session::flash('msg', '<b>Failed!</b> Batch has been not created.');
    	}

    	return redirect()->back();
    }

    //get batches record of a gym
    public function batchRecord(){
    	$bat = new Batch;
    	$res = $bat->where(['gym_id' => ProfileInformation::getUser()->id, 'is_deleted' => 1])->get();
    	return $res;
    }


    //get and set the status of batch from batch details to change it 
    public function setStatus(Request $request){
        $data = $request->validate([
                                    's' => ['required', 'numeric'],
                                    'd' => ['required', 'numeric'], 
                                ]);

        $status = $data['s'];
        $id = $data['d'];
        $bat = new Batch;
        $currentStatus = $this->changeCurrentStatus($bat, (int)$status, (int)$id);

        if($currentStatus == -1){
            return "failed";
        }

        return $currentStatus;
    }

    //delete batch of a gym
    public function delete(Request $request){
        $data = $request->validate([
                                    'd' => ['required', 'numeric'], 
                                    'password' => ['required', 'string', 'min:8'],
                                ]);

        $id = $data['d'];
        $pass = $data['password'];
        $bat = new Batch;
        $res = $this->deleteRecord($bat, $id, $pass);

        if($res == 1){
            Session::flash('msg', '<b>Success!</b> The batch has been deleted.');
        }
        else if($res == -1){
            Session::flash('msg', '<b>Invalid password!</b>.');
        }
        else{
            Session::flash('msg', '<b>Failed!</b> The batch has not deleted.');
        }
        
        return redirect()->back();
    }


}
