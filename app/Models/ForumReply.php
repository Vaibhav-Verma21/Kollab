<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ForumReply extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'forum_replies';

    protected $fillable = [
        'thread_id',
        'user_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }
}
