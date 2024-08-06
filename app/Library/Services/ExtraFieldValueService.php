<?php

namespace App\Library\Services;

use App\Models\ExtraField;
use App\Models\ExtraFieldValue;
use App\Models\Group;
use App\Models\User;
use App\Models\Image;
use App\Http\Controllers\ImageController;
use App\Models\MObject;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;

class ExtraFieldValueService
{
    const enum = ["group"=>0, "user"=>1, "object"=>2];

    public function createUser(Request $request, User $user){
        $ids = [];
        $ids[ExtraFieldValueService::enum["user"]] = $user->id;
        if($user->groups()->count() > 0){
            foreach($user->groups as $group){
                $ids[ExtraFieldValueService::enum["group"]] = $group->id;
                $this->updateGroup($request, $group, 'user', $ids);
            }
        }
    }

    public function createObject(Request $request, MObject $object){
        $ids = [];
        $ids[ExtraFieldValueService::enum["object"]] = $object->id;
        if($object->groups()->count() > 0){
            foreach($object->groups as $group){
                $ids[ExtraFieldValueService::enum["group"]] = $group->id;
                $this->updateGroup($request, $group, 'object', $ids);
            }
        }
    }

    public function updateGroup(Request $request, Group $group, $type, $ids = []){
        $ids[ExtraFieldValueService::enum["group"]] = $group->id;
        $arrayExtraFields = null;
        if($type == "group") {
            $arrayExtraFields = $group->pattern->extraFields;
        } else if($type == "user" || $type == "object") {
            $arrayExtraFields = $group->extraFields;
        }

        if($arrayExtraFields->where('type','like',$type)->count() > 0){
            foreach($arrayExtraFields->where('type','like',$type) as $field){
                //Log::error(print_r($field, true));
                if(isset($request[$field->key])){
                    $this->fillsInGroup($request[$field->key], $field, $type, $ids);
                }
            }
        }
    }

    private function fillsInGroup($request, ExtraField $exField, $type, Array $ids){
        if(empty($request)){
            return response(['errors' => "Value of extra field ".$exField->key." cannot be empty!"], 422);
        }

        if($exField->type_value !="select" && $exField->children()->count() > 0){
            foreach($exField->children as $field){
                if(isset($request[$field->key])){
                    $this->fillsInGroup($request[$field->key], $field, $type, $ids);
                }
            }
        }else{
            //Log::error(print_r($type, true));
            if($type == 'group'){
                Log::error(print_r($ids[ExtraFieldValueService::enum["group"]], true));
                if($exFValue = ExtraFieldValue::where('group_id', $ids[ExtraFieldValueService::enum["group"]])->where('extra_field_id',$exField->id)->first()){
                    $exFValue->value = $request;
                    $exFValue->save();
                }else{
                    $exFValue = [
                        'value'=>$request,
                        'type'=>$type,
                        'extra_field_id'=>$exField->id,
                        'group_id'=>$ids[ExtraFieldValueService::enum["group"]]
                    ];
                    //Log::error(print_r("passou", true));

                    ExtraFieldValue::create($exFValue);
                }
            }else if($type == 'user'){
                //Log::error(print_r($request, true));
                $skip = 0;
                $value = 0;
                if (is_array($request)) {
                    $skip = $request[0];
                    $value = $request[1];
                } else {
                    $value = $request;
                }

                if($exFValue = ExtraFieldValue::where('group_id', $ids[ExtraFieldValueService::enum["group"]])->where('user_id',$ids[ExtraFieldValueService::enum["user"]])->where('extra_field_id',$exField->id)->orderBy('created_at', 'ASC')->skip($skip)->first()){
                    $exFValue->value = $value;
                    $exFValue->save();
                }else{

                    $exFValue = [
                        'value'=>$value,
                        'type'=>$type,
                        'extra_field_id'=>$exField->id,
                        'group_id'=>$ids[ExtraFieldValueService::enum["group"]],
                        'user_id'=> $ids[ExtraFieldValueService::enum["user"]]
                    ];
                    //Log::error(print_r($exFValue, true));

                    ExtraFieldValue::create($exFValue);
                }
            }else if($type == 'object'){
                //Log::error(print_r($request, true));
                $skip = 0;
                $value = 0;
                if (is_array($request)) {
                    $skip = $request[0];
                    $value = $request[1];
                } else {
                    $value = $request;
                }

                if($exFValue = ExtraFieldValue::where('group_id', $ids[ExtraFieldValueService::enum["group"]])->where('object_id',$ids[ExtraFieldValueService::enum["object"]])->where('extra_field_id',$exField->id)->orderBy('created_at', 'ASC')->skip($skip)->first()){
                    $exFValue->value = $value;
                    $exFValue->save();
                }else{

                    $exFValue = [
                        'value'=>$value,
                        'type'=>$type,
                        'extra_field_id'=>$exField->id,
                        'group_id'=>$ids[ExtraFieldValueService::enum["group"]],
                        'object_id'=> $ids[ExtraFieldValueService::enum["object"]]
                    ];
                    //Log::error(print_r($exFValue, true));

                    ExtraFieldValue::create($exFValue);
                }
            }
        }
    }


    public function indexUser(User $user){
        $fields = [];

        if($user->groups()->count() > 0){
            foreach($user->groups as $group){
                $exFields = ExtraField::where('group_id', $group->id)->where('type', 'user')->get();
                foreach($exFields as $exField){
                    $fields[] = $this->getChildrenUser($exField, $user);
                }
            }
        }
        return $fields;
    }

    private function getChildrenUser(ExtraField $ex, User $user){
        if(!empty($ex->children())){
            $children = [];
            foreach ($ex->children as $child) {
                $children[] = $this->getChildrenUser($child, $user);
            }

            $ex->children = $children;
        }

        $ex->value = ExtraFieldValue::where('user_id',$user->id)->where('extra_field_id',$ex->id)->orderBy('created_at', 'ASC')->pluck('value')->toArray();
        return $ex;
    }

    public function indexGroup(Group $group, $hide = true){
        $fields = [];
        if($hide) {
            $exFields = ExtraField::where('group_id', $group->master_group_id)->where('type', 'group')->where('key', '<>', 'email')->get();
        } else {
            $exFields = ExtraField::where('group_id', $group->master_group_id)->where('type', 'group')->get();
        }
        //Log::error(print_r($group->master_group_id, true));
        foreach($exFields as $exField){
            //Log::error(print_r($exField->description, true));
            $fields[] = $this->getChildrenGroup($exField, $group);
        }
        //Log::error(print_r($fields, true));
        // print_r($fields);
        return $fields;
    }

    private function getChildrenGroup(ExtraField $ex, Group $group){
        if(!empty($ex->children())){
            $children = [];
            foreach ($ex->children as $child) {
                //Log::error(print_r($child->description, true));
                $children[] = $this->getChildrenGroup($child, $group);
            }
            /*if ($ex->children == 'logo') {
                $image = Image::where('group_id', '=', $group->id)->latest()->first();
                if (!empty($image)) {
                    $path = $image->path;
                    $url = (new ImageController)->getTemporaryUrlAttribute($path);

                    $ex->children = $url;
                }
            } else {*/
                $ex->children = $children;
            //}
        }
        $exFieldsValue = ExtraFieldValue::where('group_id', $group->id)->where('extra_field_id', $ex->id)->pluck('value')->toArray();
        $ex->value = $exFieldsValue;
        return $ex;
    }

    public function indexObject(MObject $object){
        $fields = [];

        if($object->groups()->count() > 0){
            foreach($object->groups as $group){
                $exFields = ExtraField::where('group_id', $group->id)->where('type', 'object')->get();
                foreach($exFields as $exField){
                    $fields[] = $this->getChildrenObject($exField, $object);
                }
            }
        }
        return $fields;
    }

    private function getChildrenObject(ExtraField $ex, MObject $object){
        if(!empty($ex->children())){
            $children = [];
            foreach ($ex->children as $child) {
                $children[] = $this->getChildrenObject($child, $object);
            }

            $ex->children = $children;
        }

        $ex->value = ExtraFieldValue::where('object_id',$object->id)->where('extra_field_id',$ex->id)->orderBy('created_at', 'ASC')->pluck('value')->toArray();
        return $ex;
    }
}
