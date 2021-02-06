<?php

namespace App\Http\Controllers;
use App\Http\Controllers\GymClasses\GymManager;

use Illuminate\Http\Request;
use Image;
use Session;

class GymController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('gymstatus')->except('showAddingForm', 'saveGym');
    }


    //shows gym adding form
    public function showAddingForm(){
        $gymManager = new GymManager;

        if($gymManager->isAvailable() === 0)
        	return view('gym.add_gym');
        elseif($gymManager->isAvailable() === 1) {
            $gymDetail = $gymManager->getMyGym();
            return view('gym.gym_detail')->with('gymDetails', $gymDetail);
        }

        return "failed";
    }

    //shows gym update form
    public function showUpdateForm(){
        $gymManager = new GymManager;
        $gymData = $gymManager->getMyGym();
        return view('gym.gym_update')->with('gymdata', $gymData);
    }

    //shows user profile update form
    public function showProfileUpdateForm(){
        $gymManager = new GymManager;
        $profile = $gymManager->getProfile();
        return view('gym.profile_update')->with('profile', $profile);
    }

    //save gym information
    public function saveGym(Request $request){
    	$data = $request->validate([
    								'gymname' => ['required', 'regex:/^[\w\s]+$/', 'max:255'],
    								'gymphone' => ['required', 'numeric', 'digits:10'],
    								'gymemail' => ['required', 'email', 'string', 'max:255'],
    								// 'adhaar' => ['required', 'numeric'],
    								'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/\'\"]+$/', 'max:255'],
                                    // 'adhaar_front' => ['required', 'image', 'max:1024'],
                                    // 'adhaar_back' => ['required', 'image', 'max:1024'],
						    	]);  	

        $gymManager = new GymManager;
        $result = $gymManager->store($data);
        if($result == 1){
            Session::flash('msg', 'Gym has been registered!');
        }
        else{
            Session::flash('msg', 'Something went wrong!');
        }
    	return redirect()->route('dashboard');
    }

    //update gym information
    public function updateGym(Request $request){
        $data = $request->validate([
                                    'gymname' => ['required', 'regex:/^[\w\s]+$/', 'max:255'],
                                    'gymphone' => ['required', 'numeric', 'digits:10'],
                                    'gymemail' => ['required', 'email', 'string', 'max:255'],
                                    'address' => ['required', 'regex:/^[\w\s\,\-\.\:\/\'\"]+$/', 'max:255'],
                                    'gym_logo' => ['nullable', 'file', 'image', 'max:1024'],
                                ]);


        $gymManager = new GymManager;
        $result = $gymManager->update($data);
        if($result == 1){
            Session::flash('msg', 'Gym information has been updated!');
        }
        else{
            Session::flash('msg', 'Something went wrong!');
        }
        return redirect()->route('add_gym');
    }

    //update profile information
    public function updateProfile(Request $request){
        $data = $request->validate([
                                    'name' => ['required', 'regex:/^[a-zA-Z\s\-\_]+$/', 'max:255'],
                                    'phone' => ['required', 'numeric', 'digits:10'],
                                    'email' => ['required', 'email', 'string'],
                                    'profile_image' => ['nullable', 'file', 'image', 'max:1024'],
                                ]);

        $gymManager = new GymManager;
        $result = $gymManager->updateUserProfile($data);
        if($result == 1){
            Session::flash('msg', 'Profile information has been updated!');
        }
        else{
            Session::flash('msg', 'Something went wrong!');
        }
        return redirect()->route('add_gym');
    }

    //update user password
    public function updateUserPassword(Request $request){
        $data = $request->validate([
                                    'old_password' => ['required', 'string', 'max:255'],
                                    'new_password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
                                ]);

        $gymManager = new GymManager;
        $result = $gymManager->updateUserProfilePassword($data);
        if($result == 1){
            Session::flash('msg', 'Password has been updated!');
        }
        else if($result == -1){
            Session::flash('msg', 'Wrong old password!');
        }
        else{
            Session::flash('msg', 'Something went wrong!');
        }
        return redirect()->back();
    }



    //feedback to squart from gym owners
    public function storeFeedback(Request $request){
        $data = $request->validate([
                                    'title' => ['required', 'string', 'max:200', 'regex:/^[\w\s\,\.\-]+$/'],
                                    'feedback' => ['required', 'string', 'max:230', 'regex:/^[\w\s\,\.\-\/\+\@\%]+$/'],
                                ]);

        $gymManager = new GymManager;
        $result = $gymManager->sentFeedback($data);
        if($result == 1){
            Session::flash('msg', 'Feedback has been sent!');
        }
        else{
            Session::flash('msg', 'Something went wrong!');
        }
        return redirect()->back();
    }


}
