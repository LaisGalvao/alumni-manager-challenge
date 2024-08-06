<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $table = 'images';
    /* Fillable */
    protected $fillable = [
        'path', 'user_id', 'group_id'
    ];

    public $appends = ['url', 'uploaded_time'];

    public function getUrlAttribute()
    {
        return Storage::disk('s3')->url($this->path);
    }

    public function getUploadedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($image) {
            $image->user_id = auth()->user()->id;
        });
    }
}
