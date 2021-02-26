<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

//custom imports
use App\Models\ApplicationFeature;

class CheckStaffPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if(auth('web')->check()){
            return $next($request);
        }

        $af = new ApplicationFeature();
        $comp_val = (int)$af->compareFeatures($role);
        if($comp_val === 1){
            return $next($request);
        }
        else if($comp_val === -1){
            return response('You are not authorised for this feature.');
        }
        else{
            return response('Something went wrong.');
        }

    }
}
