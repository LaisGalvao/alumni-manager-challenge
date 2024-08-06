<?php

namespace App\Models;

class MObject extends BaseModel
{
    protected $table = 'objects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'key', 'type', 'description'
    ];

    public function groups(){
        return $this->belongsToMany(Group::class, 'object_group', 'object_id', 'group_id')->withTimestamps();
    }

    public function users(){
        return $this->belongsToMany(User::class, 'object_user', 'object_id', 'user_id')->withTimestamps();
    }

    public function objects(){
        return $this->belongsToMany(MObject::class, 'object_object', 'object1_id', 'object2_id')->withTimestamps();
    }


    public function extraFields(){
        return $this->hasMany(ExtraField::class, 'object_id');
    }

    public function extraFieldValues(){
        return $this->hasMany(ExtraFieldValue::class, 'object_id');
    }
}
