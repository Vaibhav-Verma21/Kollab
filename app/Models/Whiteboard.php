<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Whiteboard extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'whiteboards';

    protected $fillable = [
        'uuid',
        'owner_id',
    ];
}
