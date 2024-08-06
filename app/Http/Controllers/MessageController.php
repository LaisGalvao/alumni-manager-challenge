<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Message;
use App\Models\NotificationMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $groupsIds = $user->linearChildrenId();
        $messages = Message::whereHas('recives', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        })->get();

        if(!empty($messages)){
            $response = ['messages' => $messages];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function priorityIndex()
    {
        $user = User::find(Auth::id());

        $groupsIds = $user->linearChildrenId();
        $messages = Message::whereHas('recives', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        })->where('priority',"=",1)->get();

        if(!empty($messages)){
            $response = ['messages' => $messages];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!($error = $this->isNotValidate($request))){
            //Log::error(print_r("validado", true));

            $message = Message::create($request->toArray());

            $message->recives()->attach($request->recive_ids);

            $message->notify(new NotificationMessage);

            $response = ['message' => $message];
            return response($response, 200);
        }
        return response($error, 422);
    }

    /**
     * teste is validade information
     *
     * @return bool
     */
    private function isNotValidate(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:500',
            'content' => 'required|string|max:1000',
            'priority' => 'boolean'
        ]);

        if ($validator->fails())
        {
            return ['errors'=>$validator->errors()->all()];
        }

        if(!($user = User::find($request['send_id']))){
            return ['errors'=>'User not found'];
        }

        if($user->id != Auth::id()){
            return ['errors'=>'You cannot send message by another user'];
        }

        if(!isset($request['recive_ids']) || !Group::find($request->recive_ids)){
            return ['errors'=>'One or more groups were not found'];
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $msg
     * @return \Illuminate\Http\Response
     */
    public function show(Message $msg)
    {
        $logged = User::find(Auth::id());

        $groupsIds = $logged->linearChildrenId();
        $message = Message::whereHas('recives', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        })->where('id', $msg->id)->get();

        if(!empty($message)){
            $response = ['message' => $message];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
