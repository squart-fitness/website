<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class Employee extends Model implements Authenticatable
{
    use HasFactory, Notifiable, AuthenticableTrait;

    protected $hidden = ['password'];

    public function employeePayment(){
    	return $this->hasMany('App\Models\EmployeePayment', 'employee_id');
    }
}
