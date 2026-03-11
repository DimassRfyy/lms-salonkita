<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'instructor_id',
        'price',
        'is_published',
    ];
}
