<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GroupAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('api')->check()) {
            $name = Route::currentRouteName();

            $user = User::find(Auth::id());

            $role = null;
            foreach($user->groups as $group){
                $role = $group->roles->where('key',"like",$name)->pluck('key');

                if(isset($role['0']) && $role['0']===$name){
                    break;
                }
            }

            if($role != null && isset($role['0']) && $role['0']===$name){
                return $next($request);
            }else {
                $message = ["message" => "Permission Denied by Role"];
                return response($message, 401);
            }
        } else {
            $message = ["message" => "Permission Denied"];
            return response($message, 401);
        }
    }
}
