<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'quiz_attempts';

    protected $fillable = [
        'user_id',
        'course_id',
        'attempts_count',
        'latest_score',
    ];
}
