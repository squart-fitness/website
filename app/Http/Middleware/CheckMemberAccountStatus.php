<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

class CheckMemberAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        $gymID = (int)$request->route('gym_id');
        $username = $request->route('gym_username');

        if(isset($username)){
            $gym = User::select('id')->where(['username' => $username, 'status' => 1, 'is_deleted' => 1])->first();
            $gymID = (int)$gym->id;
        }

        $obj = Customer::checkStatus($gymID, (int)$request->route('customer_id'));
        if(!isset($obj)){
            $error = array('title' => 'Not exist', 'message' => 'Gym and Member missmatch', 'response_code' => 401);
            return response()->json($error, 401);
        }

        $status = (int)$obj->status;
        $deleted = (int)$obj->is_deleted;

        if($deleted === 0){
            $error = array('title' => 'Deleted', 'message' => 'Member account has been deleted. Please contact your gym.', 'response_code' => 401);
            return response()->json($error, 401);
        }

        if($status === 0){
            $error = array('title' => 'Deactivated', 'message' => 'Member account has been deactivated. Please contact your gym.', 'response_code' => 401);
            return response()->json($error, 401);
        }
       
        return $next($request);
    }
}
