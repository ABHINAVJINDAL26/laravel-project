<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Blog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'blogs';

    protected $fillable = [
        'title',
        'category',
        'tags',
        'content',
        'cover_image_url',
        'is_featured',
        'read_time_min',
        'likes',
        'user_id',
        'liked_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'likes'       => 'integer',
    ];
}
