<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'customer_payment';

    public function customer(){
    	return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function gym(){
    	return $this->belongsTo('App\Models\User', 'gym_id', 'id');
    }
}
