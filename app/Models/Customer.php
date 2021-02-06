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
}
