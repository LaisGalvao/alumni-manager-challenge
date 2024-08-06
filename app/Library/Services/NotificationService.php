<?php

namespace App\Library\Services;

use App\Models\User;
use App\Models\MNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function createNotification(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:255|unique:notifications',
            //'user_id' => 'string|max:255'
        ]);

        if(isset($request['user_id']) && !(User::find($request['user_id']))){
            return ['errors'=>"Not found user", 'response'=>2];
        }

        if ($validator->fails())
        {
            return ['errors'=>$validator->errors()->all(), 'response'=>3];
        }

        MNotification::create($request->toArray());

        return ['response'=>0];;
    }

    public function updateNotification(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:255',
            'telephone' => 'string|min:11|celular_com_ddd',
            'user_id' => 'string|max:255'
        ]);

        $token = MNotification::where("token","=",$request['token'])->first();

        if($token == null){
            return $this->createNotification($request);
        }

        if(isset($request['user_id']) && !(User::find($request['user_id']))){
            return ['errors'=>"Not found user", 'response'=>2];
        }

        if ($validator->fails())
        {
            return ['errors'=>$validator->errors()->all(), 'response'=>3];
        }

        MNotification::create($request->toArray());

        return ['response'=>0];;
    }
}
