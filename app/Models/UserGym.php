<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGym extends Model
{
    use HasFactory;

    protected $table = 'user_gym';


    public function isActive(){
    	$res = UserGym::select('status')->where('gym_id', '=', auth()->user()->id)->first();
    	if(isset($res) && !empty($res))
	    	return $res->status;
	    else{
	    	return -1;
	    }
    }
}
