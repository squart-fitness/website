<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Setting extends Model
{
    use HasFactory;


    //Api check
	public static function apiCheck($key, $device){
		$validator = Validator::make(['key' => $key, 'device' => $device], [
											'key' => ['required', 'max:230', 'regex:/^[a-zA-Z0-9]+$/'],
											'device' => ['required', 'max:100', 'regex:/^[a-zA-Z]+$/'],
									]);

		if($validator->fails()){
			return 0;
		}

		$setting = Setting::where(['api_key' => $key, 'usages_in' => $device])->first();
		if(isset($setting)){
			return 1;
		}
		else{
			return 0;
		}
	}
}
