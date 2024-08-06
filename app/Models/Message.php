<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;


class Message extends BaseModel
{
    use Notifiable;

    protected $table = 'messages';

    protected $fillable = [
        'id', 'title', 'subject', 'content', 'priority', 'send_id'
    ];

    public function send(){
        return $this->belongsTo(User::class, 'send_id');
    }

    public function recives(){
        return $this->belongsToMany(Group::class, 'message_group', 'message_id', 'group_id')->withTimestamps();
    }

    public function routeNotificationForFcm()
    {
        $tokens = [];
        foreach($this->recives as $group){
            foreach($group->users as $user){
                $tokens = array_merge($tokens, $user->notifications()->pluck('token')->toArray());
            }
        }
        return $tokens;
    }
}
