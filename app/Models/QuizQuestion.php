<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'quiz_questions';

    protected $fillable = [
        'course_id',
        'question_text',
        'options',
        'correct_option',
    ];
}
