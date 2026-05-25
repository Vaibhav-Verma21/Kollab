<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WhiteboardAction extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'whiteboard_actions';

    protected $fillable = [
        '_id',
        'id',
        'user_id',
        'username',
        'color',
        'type',
        'points',
        'text',
        'size',
        'created_at_ms',
    ];
}
