<?php

namespace App\Http\Controllers;

use App\Library\Services\ExtraFieldValueService;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\MObject;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = MObject::orderBy('updated_at');

        if(isset($request->user_id)){
            $query = $query->whereHas('users', function ($user) use ($request) {
                $user->where('id', $request->user_id);
            });
        }

        if (isset($request->wheres)) {
            foreach ($request->wheres as $where) {
                switch ($where['type']) {
                    case 'where':
                        $query = $query->where($where['field'], $where['condition'], $where['value']);
                        break;
                    case 'whereHas':
                        $query = $query->whereHas($where['fields'], function ($obj) use ($where) {
                            $obj->where($where['field'], $where['condition'], $where['value']);
                        });
                        break;
                }
            }
        }

        $objects = $query->get();

        if (!empty($objects)) {
            $efvService = new ExtraFieldValueService();

            foreach ($objects as $object) {
                $object->extra_fields = $efvService->indexObject($object);
                $object->groups = $this->linkGroup($object, $request);
                $object->users = $this->linkUser($object, $request);
                $object->objects = $this->linkObject($object, $request);
            }


            $response = ['objects' => $objects];
            return response($response, 200);
        }

        return response(['errors' => 'Not found'], 422);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!($error = $this->isNotValidate($request))){
            $object = MObject::create($request->toArray());

            $object->groups = $this->linkGroup($object, $request);
            $object->users = $this->linkUser($object, $request);
            $object->objects = $this->linkObject($object, $request);

            $efvService = new ExtraFieldValueService();
            $efvService->createObject($request, $object);
            $object->extra_fields = $efvService->indexObject($object);

            $response = ['object' => $object];
            return response($response, 200);
        }
        return response($error, 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  MObject $object
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MObject $object)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'string|max:255',
            'type' => 'string|max:255',
            'description' => 'string|max:500'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $object->key = (isset($request['key']))? $request['key']: $object->key;
        $object->type = (isset($request['type']))? $request['type']: $object->type;
        $object->description = (isset($request['description']))? $request['description']: $object->description;

        $object->save();

        $object->groups = $this->linkGroup($object, $request);
        $object->users = $this->linkUser($object, $request);
        $object->objects = $this->linkObject($object, $request);

        $efvService = new ExtraFieldValueService();
        $efvService->createObject($request, $object);
        
        $object->extra_fields = $efvService->indexObject($object);

        $response = ['object' => $object];
        return response($response, 200);
    }

    private function linkGroup(MObject $object, Request $request)
    {
        if (isset($request->group_key)) {
            $group = Group::where('key', $request->group_key)->first();
            $object->groups()->attach($group->id);
        }

        if (isset($request->group_keys)) {
            foreach ($request->group_keys as $group_key) {
                $group = Group::where('key', $group_key)->first();
                $object->groups()->attach($group->id);
            }
        }

        return $object->groups;
    }

    private function linkUser(MObject $object, Request $request)
    {
        if (isset($request->user_id)) {
            $user = User::find($request->user_id);
            $object->users()->attach($user->id);
        }

        if (isset($request->user_ids)) {
            foreach ($request->user_ids as $user_id) {
                $user = User::find($user_id);
                $object->users()->attach($user->id);
            }
        }

        return $object->users;
    }

    private function linkObject(MObject $object, Request $request)
    {
        if (isset($request->object_key)) {
            $object = MObject::where('key', $request->object_key)->first();
            $object->objects()->attach($object->id);
        }

        if (isset($request->group_keys)) {
            foreach ($request->group_keys as $group_key) {
                $object = MObject::where('key', $request->object_key)->first();
                $object->objects()->attach($object->id);
            }
        }

        return $object->objects;
    }

    /**
     * Display the specified resource.
     *
     * @param  MObject $object
     * @return \Illuminate\Http\Response
     */
    public function show(MObject $object)
    {
        $efvService = new ExtraFieldValueService();
        $object->extra_fields = $efvService->indexObject($object);

        $response = ['object' => $object];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MObject $object
     * @return \Illuminate\Http\Response
     */
    public function destroy(MObject $object)
    {
        //
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
            'description' => 'string|max:500'
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        return false;
    }
}
