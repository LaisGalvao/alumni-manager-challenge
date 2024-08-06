<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraField extends BaseModel
{
    protected $table = 'extra_fields';

    protected $fillable = [
        'id', 'key', 'name', 'description', 'type_value', 'type', 'mask', 'required', 'order', 'group_id', 'object_id', 'master_extra_field'
    ];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function object(){
        return $this->belongsTo(MObject::class, 'object_id');
    }

    public function pattern(){
        return $this->belongsTo(ExtraField::class, 'master_extra_field');
    }

    public function children(){
        return $this->hasMany(ExtraField::class, 'master_extra_field');
    }

    public function values(){
        return $this->hasMany(ExtraFieldValue::class, 'extra_field_id');
    }
}
