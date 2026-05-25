<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'courses';

    protected $fillable = [
        'title',
        'slug',
        'domain',
        'duration',
        'level',
        'description',
        'theme_color',
    ];
}
