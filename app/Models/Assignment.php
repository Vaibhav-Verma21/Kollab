<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Assignment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'assignments';

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'due_date',
        'rubric', // Array of criteria and weights
    ];
}
