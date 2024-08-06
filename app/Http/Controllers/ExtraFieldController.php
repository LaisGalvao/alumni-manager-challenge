<?php

namespace App\Http\Controllers;

use App\Models\ExtraField;
use App\Models\ExtraFieldValue;
use App\Models\Group;
use App\Models\User;
use App\Library\Services\ExtraFieldValueService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtraFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        $user = User::find(Auth::id());

        $groupsIds = $user->groups()->pluck('id')->toArray();
        return $this->return_extra_fields($groupsIds, 'user');
    }

    private function return_extra_fields($groupsIds, $type){
        $extra_fields = ExtraField::where('type', 'like', $type)->whereHas('group', function($group) use($groupsIds) {
            $group->whereIn('id', $groupsIds);
        })->get();

        $extra_fields_b = [];
        foreach ($extra_fields as $field) {
            $extra_fields_b[] = $this->getChildren($field);
        }

        if(!empty($extra_fields_b)){
            $response = ['extra_fields' => $extra_fields_b];
            return response($response, 200);
        }

        return response(['errors'=>"Not Found"], 422);
    }



    private function getChildren(ExtraField $ex){
        if(!empty($ex->children())){
            $children = [];
            foreach ($ex->children as $child) {
                $children[] = $this->getChildren($child);
            }
            $ex["children"] = $children;
        }
        return $ex;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function useringroup(Request $request)
    {
        $groupsIds = Group::where('key','=',$request['group_key'])->pluck('id')->toArray();
        return $this->return_extra_fields($groupsIds, 'user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!($error = $this->isNotValidate($request))){
            $extra_field = ExtraField::create($request->toArray());

            $response = ['extra_field' => $extra_field];
            return response($response, 200);
        }
        return response($error, 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ExtraField  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraField $ex)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'string|max:500',
            'type_value' => 'string|max:255',
            'type' => 'string|max:255',

            'required' => 'boolean',
            'order' => 'integer',
            'mask' => 'string|max:255',
            'group_id' => 'string|max:255',
            'master_extra_field' => 'string|max:255'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $ex->description = (isset($request['description']))? $request['description'] : $ex->description;
        $ex->type_value = (isset($request['type_value']))? $request['type_value'] : $ex->type_value;
        $ex->type = (isset($request['type']))? $request['type'] : $ex->type;

        $ex->required = (isset($request['required']))? $request['required'] : $ex->required;
        $ex->order = (isset($request['order']))? $request['order'] : $ex->order;
        $ex->mask = (isset($request['mask']))? $request['mask'] : $ex->mask;
        $ex->group_id = (isset($request['group_id']))? $request['group_id'] : $ex->group_id;
        $ex->master_extra_field = (isset($request['master_extra_field']))? $request['master_extra_field'] : $ex->master_extra_field;

        $ex->save();

        $response = ['extra_field' =>$ex];

        return response($response, 200);
    }

    public function ownerDelete(Request $request) {
        $user = User::find($request['user_id']);

        if($user == null){
            return response(['errors'=>'User not found'], 422);
        }

        return $this->deleteExtraFieldValue($request, $user);
    }

    public function extraFieldDelete(Request $request, User $user) {
        if($user->id != Auth::id()){
            return response(['errors'=>'You do not have permission to edit this user'], 422);
        }

        return $this->deleteExtraFieldValue($request, $user);
    }

    private function deleteExtraFieldValue(Request $request, User $user) {
        $validator = Validator::make($request->all(), [
            'index' => 'integer',
            'key' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        $id_groups = collect($user->groups)->pluck('id')->toArray();

        $extra_field = ExtraField::whereIn('group_id', $id_groups)->where('key', $request->key)->first();

        $this->deleteChildrenExtraFields($extra_field, $user, $request->index);

        $efvService = new ExtraFieldValueService();
        $user->extra_fields = $efvService->indexUser($user);

        $response = ['user' => $user];
        return response($response, 200);
    }

    private function deleteChildrenExtraFields(ExtraField $ex, User $user, $index) {
        if(!empty($ex->children())){
            foreach ($ex->children as $child) {
                $this->deleteChildrenExtraFields($child, $user, $index);
            }
        }

        $exFValue = ExtraFieldValue::where('user_id',$user->id)->where('extra_field_id',$ex->id)->orderBy('created_at', 'ASC')->skip($index)->first();

        if($exFValue) {
            $exFValue->delete();
        }
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

    private function isNotValidate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:500',
            'type_value' => 'required|string|max:255',
            'type' => 'required|string|max:255',

            'required' => 'boolean',
            'order' => 'integer',
            'mask' => 'string|max:255',
            'group_id' => 'string|max:255',
            'master_extra_field' => 'string|max:255'
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        return false;
    }
}
