<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PeerReview extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'peer_reviews';

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'rubric_scores', // Array matching rubric criteria
        'comments',
        'total_score',
        'is_completed',
    ];
}
