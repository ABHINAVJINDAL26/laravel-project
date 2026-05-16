<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Recipe extends Eloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'recipes';

    protected $fillable = [
        'title',
        'description',
        'ingredients',
        'process',
        'origin',
        'rating',
        'image'
    ];
}
