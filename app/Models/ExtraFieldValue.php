<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraFieldValue extends BaseModel
{
    protected $table = 'extra_field_values';

    protected $fillable = [
        'id', 'value', 'type', 'group_id', 'user_id', 'object_id', 'extra_field_id'
    ];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function object(){
        return $this->belongsTo(MObject::class, 'object_id');
    }

    public function extra_field(){
        return $this->belongsTo(ExtraField::class, 'extra_field_id');
    }
}
