<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    protected $table = 'roles';

    protected $fillable = [
        'id', 'key', 'description'
    ];

    public function groups(){
        return $this->belongsToMany(Group::class, 'role_group', 'role_id', 'group_id')->withTimestamps();
    }
}
