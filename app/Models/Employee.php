<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

// custom imports
use App\Http\Controllers\ProfileInformation;


class Employee extends Model implements Authenticatable
{
    use HasFactory, Notifiable, AuthenticableTrait;

    protected $hidden = ['password'];

    public function employeePayment(){
    	return $this->hasMany('App\Models\EmployeePayment', 'employee_id');
    }

    public function getAdmin(){
    	return $this->belongsTo('App\Models\User', 'gym_id', 'id');
    }

    public function getApplicationFeatures(){
    	return $this->belongsToMany('App\Models\ApplicationFeature', 'gym_staff_permissions', 'staff_id', 'feature_id')->where(['gym_staff_permissions.gym_id' => ProfileInformation::getUser()->id, 'gym_staff_permissions.status' => 1]);
    }
}
