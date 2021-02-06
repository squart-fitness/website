<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class APIKey
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
        $keyCheck = Setting::apiCheck($request->header('api_token'), $request->header('device'));
        if($keyCheck == 0){
            $error = array('title' => 'Invalid', 'message' => 'The API key provided is invalid or device is invalid.');
            return response()->json($error, 401);
        }

        return $next($request);
    }
}
