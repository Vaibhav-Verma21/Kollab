<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ForumThread extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'forum_threads';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'thread_id');
    }
}
