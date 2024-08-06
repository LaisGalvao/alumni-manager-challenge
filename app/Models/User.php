<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use GoldSpecDigital\LaravelEloquentUUID\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'telephone', 'cpf', 'tenant_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function groups(){
        return $this->belongsToMany(Group::class, 'user_group', 'user_id', 'group_id')->withTimestamps();
    }

    public function objects(){
        return $this->belongsToMany(MObject::class, 'object_user', 'user_id', 'object_id')->withTimestamps();
    }

    public function extra_field_values(){
        return $this->hasMany(ExtraFieldValue::class, 'user_id');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'user_id');
    }

    public function packets_send(){
        return $this->hasMany(Send::class, 'sender_id');
    }

    public function packets_receive(){
        return $this->hasMany(Send::class, 'reive_id');
    }

    public function notifications(){
        return $this->hasMany(MNotification::class, 'user_id');
    }

    public function servicesRange(){
        return $this->hasMany(ServiceRange::class, 'user_id');
    }

    public function linearChildrenId(){
        if(empty($this->groups))
            return null;
        $all = [];
        foreach($this->groups as $group){
            $all = array_merge($all, $group->linearChildrenId());
        }
        return $all;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'user_id')->latest();
    }
}
