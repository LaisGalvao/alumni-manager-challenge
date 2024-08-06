<?php

namespace App\Models;

class Group extends BaseModel
{
    protected $table = 'groups';

    protected $fillable = [
        'id', 'key', 'type','public', 'description', 'master_group_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'user_group', 'group_id', 'user_id')->withTimestamps();
    }

    public function objects(){
        return $this->belongsToMany(MObject::class, 'object_group', 'group_id', 'object_id')->withTimestamps();
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_group', 'group_id', 'role_id')->withTimestamps();
    }

    public function messages(){
        return $this->belongsToMany(Message::class, 'message_group', 'group_id', 'message_id')->withTimestamps();
    }

    public function pattern(){
        return $this->belongsTo(Group::class, 'master_group_id');
    }

    public function children(){
        return $this->hasMany(Group::class, 'master_group_id');
    }

    public function extraFields(){
        return $this->hasMany(ExtraField::class, 'group_id');
    }

    public function extraFieldValues(){
        return $this->hasMany(ExtraFieldValue::class, 'group_id');
    }

    public function linearChildrenId(){
        if(empty($this->children))
            return [$this->id];
        $all = [$this->id];
        foreach($this->children as $group){
            $all = array_merge($all, $group->linearChildrenId());
        }
        return $all;
    }
}
