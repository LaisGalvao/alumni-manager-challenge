<?php

namespace App\Http\Controllers;

use App\Commons;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->group_ids)){
            $groupsIds = Commons::stringIdsToArray($request->group_ids);
        }else{
            $user = User::find(Auth::id());

            $groupsIds = $user->linearChildrenId();
        }

        $roles = Role::whereHas('groups', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        })->get();

        if(!empty($roles)){
            $response = ['roles' => $roles];
            return response($response, 200);
        }

        return response(['errors'=>'Not found'], 422);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!($error = $this->isNotValidate($request))){
            $role = Role::create($request->toArray());

            $response = ['role' => $role];
            return response($response, 200);
        }
        return response($error, 422);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function linkGroup(Request $request, Role $role)
    {
        if(!isset($request->group_id) && !isset($request->group_ids)){
            return response(['errors'=>'The group_id or array of group_ids is required'], 422);
        }

        if(isset($request->group_id)){
            $role->groups()->attach($request->group_id);
        }

        if(isset($request->group_ids)){
            $role->groups()->attach($request->group_ids);
        }

        $response = ['role' => $role];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $user = User::find(Auth::id());

        $groupsIds = $user->linearChildrenId();
        $roles = Role::whereHas('groups', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        })->where('id', $role->id)->get();

        if(!empty($roles)){
            $response = ['role' => $roles];
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
    public function update(Request $request, Role $id)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return bool
     */
    private function isNotValidate(Request $request){
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);
        if ($validator->fails())
        {
            return ['errors'=>$validator->errors()->all()];
        }

        return false;
    }
}
