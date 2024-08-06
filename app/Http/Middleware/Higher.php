<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class Higher
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
        $higher = User::find(Auth::id());

        $step = true;
        if(isset($request['user_id'])){
            $user = User::find($request['user_id']);

            if($user == null){
                return response(['errors'=>'User not found'], 422);
            }

            if(!empty($user->linearChildrenId())){
                $step = false;

                $intersect = array_intersect_key($user->linearChildrenId(), $higher->linearChildrenId());
                if(!empty($intersect)){
                    $step = true;
                }
            }
        }

        if(isset($request['group_id'])){
            $step = false;

            //Log::error(print_r($request['group_id'], true));
            if(in_array($request['group_id'], $higher->linearChildrenId())){
                $step = true;
            }
        }

        if(isset($request['group_ids'])){
            $step = false;
            $intersect = array_intersect_key($request['group_ids'], $higher->linearChildrenId());
            if(empty($intersect)){
                $message = ["message" => "Your permissions do not allow you to edit this groups"];
                return response($message, 401);
            }else if(!empty($intersect) && count($intersect)<count($request['group_ids'])){
                $message = ["message" => "Your permissions do not allow you to edit anyway of groups the list"];
                return response($message, 401);
            }else{
                $step = true;
            }
        }

        if($step){
            return $next($request);
        }else {
            $message = ["message" => "Your permissions do not allow you to edit this group"];
            return response($message, 401);
        }

    }
}
