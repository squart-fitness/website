<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;

    protected $hidden = ['password'];

    protected $fillable = ['status'];


    public function payment(){
    	return $this->hasMany('App\Models\Payment', 'customer_id');
    }

     public function attendance(){
    	return $this->hasMany('App\Models\Attendance', 'customer_id')
    						  ->join('customers', 'attendance.customer_id', '=', 'customers.id')
    						  ->select('customers.name', 'customers.phone', 'attendance.present', 'attendance.attendance_date');
    }


    //check member status in gym for mobile application
    public static function checkStatus($gym_id, $customer_id){
        $user = Customer::select('status', 'is_deleted')->where(['gym_id' => $gym_id, 'id' => $customer_id])->first();
        return $user;
    }

    //access associated gym
    public function gym(){
        return $this->belongsTo('App\Models\User', 'gym_id', 'id');
    }

}
