<?php 

namespace App\Http\Controllers;

use Session;

class ProfileInformation{
	private static $id, $username, $name, $email, $phone, $role, $profile_image, $status, $is_deleted, $created_at, $updated_at;
	public static $user;

	//get gym user auth details
	public static function setUser($userInfo){
		// session(['user_info' => $userInfo]);
		Session::put('user_info', $userInfo);
		Session::save();
	}

	//get gym user auth details
	public static function getUser(){
		$user = Session::get('user_info');
		return $user;
	}
}

