<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserGym;
use Session;

class CheckGymStatus
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
        $gym = new UserGym;
        if($gym->isActive() == 0){
            // Session::flash('deactivated', 'You are deactivated from using the service.');
            return redirect()->route('deactivated');
        }
        else if($gym->isActive() == -1){
            Session::flash('not_added', 'You have to first add your gym details.');
            // redirect('gym/add');
            return redirect()->route('add_gym');
        }

        return $next($request);
    }
}
