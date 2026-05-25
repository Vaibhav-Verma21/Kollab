<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WhiteboardUser extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'whiteboard_users';

    protected $fillable = [
        'user_id',
        'name',
        'x',
        'y',
        'color',
        'last_seen',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];
}
