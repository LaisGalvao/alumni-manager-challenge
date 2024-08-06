<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Library\Services\ExtraFieldValueService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
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
        $groups = Group::find($groupsIds);

        if(!empty($groups)){
            $response = ['groups' => $groups];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex(Request $request)
    {
        $user = User::find($request['user_id']);

        $groupsIds = $user->linearChildrenId();
        $groups = Group::find($groupsIds);

        if(!empty($groups)){
            $response = ['groups' => $groups];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Display a listing public of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function publicIndex()
    {
        $groups = Group::where('public', '=', 1)->get();

        if(!empty($groups)){
            $efvService = new ExtraFieldValueService();

            foreach($groups as $group) {
             $group->extra_fields = $efvService->indexGroup($group);
            }

            $response = ['groups' => $groups];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Relaciona um usuário em um grupo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function linkUser(Request $request)
    {
        if(!isset($request->group_id) && !isset($request->group_ids)){
            return response(['errors'=>'The group_id or array of group_ids is required'], 422);
        }

        if(isset($request->user_id)){
            $user = User::find($request['user_id']);

            if($user == null){
                return response(['errors'=>'User not found'], 422);
            }

            $this->linkGroup($user, $request);

            $response = ['user' => $user];
        }else if(isset($request->user_ids)){
            $users = User::whereIn($request->user_ids)->get();

            if(empty($users)){
                return response(['errors'=>'Users not found'], 422);
            }

            foreach ($users as $user){
                $this->linkGroup($user, $request);
            }
        }else{
            return response(['errors'=>'The user_id or array of user_ids is required'], 422);
        }

        return response($response, 200);
    }

    private function linkGroup(User $user, Request $request){
        if(isset($request->group_id)){
            $user->groups()->attach($request->group_id);
        }

        if(isset($request->group_ids)){
            $user->groups()->attach($request->group_ids);
        }
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
            $group = Group::create($request->toArray());

            $response = ['group' => $group];
            return response($response, 200);
        }
        return response($error, 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'string|max:255'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $group = Group::find($request['group_id']);

        if(!empty($group)){
            $efvService = new ExtraFieldValueService();
            $group->extra_fields = $efvService->indexGroup($group);
            //Log::error(print_r($group, true));
            $response = ['group' => $group];
            //Log::error(print_r($response, true));
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $group = Group::find($request['group_id']);
        if ($group == null){
            return response(['errors'=>'Not found group'], 422);
        }

        $validator = Validator::make($request->all(), [
            'key' => 'string|max:255',
            'type' => 'string|max:255',
            'description' => 'string|max:500',
            'master_group_id' => 'string|max:255'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $group->key = (isset($request['key']))? $request['key']: $group->key;
        $group->type = (isset($request['type']))? $request['type']: $group->type;
        $group->description = (isset($request['description']))? $request['description']: $group->description;
        $group->public = (isset($request['public'])) ? $request['public']: $group->public;

        if (isset($request['master_group_id'])){
            $master_group = Group::find($request['master_group_id']);
            if($master_group){
                $group->master_group_id = $request['master_group_id'];
            }
        }

        $efvService = new ExtraFieldValueService();
        $efvService->updateGroup($request, $group, 'group');

        $group->save();
        $group->extra_fields = $efvService->indexGroup($group);
        $response = ['group' => $group];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'string|max:255'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $group = Group::find($request['group_id']);

        if(!empty($group)){
            try{
                $group->delete();
                //Log::error(print_r($group, true));
                $response = ['Message' => "Deleted with success"];
                //Log::error(print_r($response, true));
                return response($response, 200);
            }catch(Exception $e){
                return response(['errors'=>'Not possible deleted group'], 422);
            }
            return response(['errors'=>'Not exist group'], 422);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool
     */
    private function isNotValidate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'master_group_id' => 'string|max:255'
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        return false;
    }
}
