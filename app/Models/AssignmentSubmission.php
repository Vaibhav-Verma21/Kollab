<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'assignment_submissions';

    protected $fillable = [
        'assignment_id',
        'user_id',
        'github_url',
        'notes',
        'status', // e.g., 'submitted', 'reviewed'
        'grade',
        'graded_by',
    ];
}
