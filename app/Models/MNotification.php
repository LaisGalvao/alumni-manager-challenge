<?php

namespace App\Models;

class MNotification extends BaseModel
{
    protected $table = 'notifications';

    protected $fillable = [
        'id', 'token', 'telephone', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
